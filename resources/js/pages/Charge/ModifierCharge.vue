<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-size-66">
        <form @submit.prevent="updateCharge" enctype="multipart/form-data">
          <md-card>
            <md-card-header data-background-color="green">
              <h4 style="font-weight: regular;" class="title">التكاليف</h4>
              <p class="category" style="font-size:20px;font-weight: bold;">تعديل كلفة</p>
            </md-card-header>



            <md-card-content>
              <div class="md-layout">
                <div class="md-layout-item md-small-size-100 md-size-55">
                  <md-field>
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"> نوع التكليف</label>
                    <md-select v-model="selected">
                      <md-option v-for="type in types" :key="type.id" :value="type.id">{{type.libele}}</md-option>
                    </md-select>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field :class="getValidationClass('montant_total')">
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">المبلغ الإجمالي</label>
                    <md-input type="text" v-model="charge.montant_total" :disabled="sending"></md-input>
                    <span class="md-error" v-if="!$v.charge.montant_total.required">المبلغ الإجمالي ضروروي</span>
                    <span class="md-error" v-else-if="!$v.charge.montant_total.numeric">المبلغ الإجمالي لا يحتوي على
                      حروف</span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field>
                    <label  style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">التاريخ</label>
                    <md-input type="date" v-model="charge.date"></md-input>
                  </md-field>
                </div>

                <div class="md-layout-item md-size-100 text-right">
                  <md-button style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;" type="submit" class="md-raised md-success">تعديل</md-button>
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
  export default {
    name: "modifier-charge",
    mixins: [validationMixin],
    props: {
      dataBackgroundColor: {
        type: String,
        default: ""
      }
    },
    data() {
      return {
        selected: "",
        types: [],
        charge: new Object(),
        sending: false,
        token : localStorage.getItem('token'),
      };
    },
    created() {
      this.charge = this.$route.params.charge;
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
            console.log(this.types);
            this.selected = this.types[0].id;
          })
          .catch(err => console.log(err));
      },
      updateCharge() {
        this.$v.$touch();
        if (!this.$v.$invalid) {
          this.sending = true;
          this.charge.type_charge_id = this.selected;


          fetch(`api/charge/${this.charge.id}`, {
            method: "put",
            body: JSON.stringify(this.charge),
            headers: {
              "content-type": "application/json"
            }

          })
            .then(res => res.json())
            .then(res => {
              this.$router.push({ name: 'ChargeHeader' });
            })
            .catch(err => console.log(err));

        }
      }
    }
  };
</script>


<style>
</style>