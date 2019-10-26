<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-size-66">
        <form @submit.prevent="addCharge" enctype="multipart/form-data">
          <md-card>
            <md-card-header data-background-color="green">
              <h4 style="font-weight: regular;">التكاليف</h4>
              <p class="category" style="font-size:20px;font-weight: bold;">تدبير التكاليف</p>
            </md-card-header>

            <md-card-content>
              <div class="md-layout">
                <div class="md-layout-item md-small-size-100 md-size-55">
                  <md-field>
                    <label
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    >نوع التكليف</label>
                    <md-select v-model="selected">
                      <md-option
                        v-for="type in types"
                        :key="type.id"
                        :value="type.id"
                      >{{type.libele}}</md-option>

                      <md-option color="primary" @click.native="modal = true">إضافة نوع جديد</md-option>
                    </md-select>
                  </md-field>
                </div>
                <mdb-modal :show="modal" @close="modal = false">
                  <mdb-modal-header>
                    <mdb-modal-title>إضافة نوع جديد</mdb-modal-title>
                  </mdb-modal-header>
                  <mdb-modal-body>
                    <input
                      class="form-control form-control-lg"
                      type="text"
                      v-model="type_charge.libele"
                      placeholder="نوع التكليف"
                    />
                  </mdb-modal-body>
                  <mdb-modal-footer>
                    <mdb-btn @click="addTypeCharge()" color="primary">حفظ التغييرات</mdb-btn>
                    <mdb-btn
                      color="secondary"
                      style="margin :10px;"
                      @click.native="modal = false"
                    >إغلاق</mdb-btn>
                  </mdb-modal-footer>
                </mdb-modal>

                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field :class="getValidationClass('montant_total')">
                    <label
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    >المبلغ الإجمالي</label>
                    <md-input type="text" v-model="charge.montant_total" :disabled="sending"></md-input>
                    <span
                      class="md-error"
                      v-if="!$v.charge.montant_total.required"
                    >المبلغ الإجمالي ضروروي</span>
                    <span class="md-error" v-else-if="!$v.charge.montant_total.numeric">
                      المبلغ الإجمالي لا يحتوي على
                      حروف
                    </span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field>
                    <label
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    >التاريخ</label>
                    <md-input type="date" v-model="charge.date"></md-input>
                  </md-field>
                </div>

                <div class="md-layout-item md-size-100 text-right">
                  <md-button
                    style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    type="submit"
                    class="md-raised md-success"
                  >إضافة</md-button>
                </div>
              </div>
            </md-card-content>
          </md-card>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import { validationMixin } from "vuelidate";
import {
  required,
  minLength,
  maxLength,
  numeric,
  alpha
} from "vuelidate/lib/validators";
import {
  mdbModal,
  mdbModalHeader,
  mdbModalTitle,
  mdbModalBody,
  mdbModalFooter,
  mdbBtn
} from "mdbvue";
export default {
  components: {
    mdbModal,
    mdbModalHeader,
    mdbModalTitle,
    mdbModalBody,
    mdbModalFooter,
    mdbBtn
  },
  name: "ajouter-charge",
  mixins: [validationMixin],
  props: {
    dataBackgroundColor: {
      type: String,
      default: ""
    }
  },
  data() {
    return {
      type_charge: {
        libele: ""
      },
      modal: false,
      types: [],
      charges: [],
      selected: "",
      charge: {
        type_charge_id: "",
        montant_total: "",
        date: this.formatDate(new Date())
      },
      sending: false,
      token : localStorage.getItem('token'),
    };
  },
  created() {
    this.remplirCombo();
  },
  validations: {
    charge: {
      montant_total: {
        required,
        numeric
      }
    }
  },
  methods: {
    formatDate(date1) {
      return (
        date1.getFullYear() +
        "-" +
        (date1.getMonth() < 9 ? "0" : "") +
        (date1.getMonth() + 1) +
        "-" +
        (date1.getDate() < 10 ? "0" : "") +
        date1.getDate()
      );
    },
    getValidationClass(fieldName) {
      const field = this.$v.charge[fieldName];

      if (field) {
        return {
          "md-invalid": field.$invalid && field.$dirty
        };
      }
    },
    remplirCombo() {
      fetch("/api/typeCharges?token="+this.token)
        .then(res => res.json())
        .then(res => {
          //affecter res.data a articles
          this.types = res.data;
          this.selected = this.types[0].id;
        })
        .catch(err => console.log(err));
    },
    addTypeCharge() {
      fetch("api/typeCharges?token="+this.token, {
        method: "post",
        body: JSON.stringify(this.type_charge),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          this.remplirCombo();
          this.modal = false;
        })
        .catch(err => console.log(err));

      //}
    },
    addCharge() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.sending = true;
        this.charge.type_charge_id = this.selected;
        const token = localStorage.getItem("token");
        fetch("api/charge?token=" + this.token, {
          method: "post",
          body: JSON.stringify(this.charge),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {
            this.$router.push({ name: "ChargeHeader" });
          })
          .catch(err => console.log(err));
      }
    }
  }
};
</script>


<style>
</style>