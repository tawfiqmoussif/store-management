<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-size-66">
        <form novalidate @submit.prevent="addClient" enctype="multipart/form-data">
          <md-card>
            <md-card-header data-background-color="green">
              <h4 style="font-weight: regular;" class="title">الزبناء</h4>
              <p style="font-size:20px;font-weight: bold;" class="category">تدبير الزبناء</p>
            </md-card-header>

            <md-card-content>
              <div class="md-layout">
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field :class="getValidationClass('prenom')">
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">الاسم الشخصي</label>
                    <md-input type="text" v-model="personne.prenom" :disabled="sending"></md-input>
                    <span class="md-error" v-if="!$v.personne.prenom.required">الإسم الشخصي ضروري</span>
                    <span
                      class="md-error"
                      v-else-if="!$v.personne.prenom.minlength"
                    >الإسم الذي أدخلته لا يوجد</span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field :class="getValidationClass('nom')">
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">الاسم العائلي</label>
                    <md-input type="text" v-model="personne.nom" :disabled="sending"></md-input>
                    <span class="md-error" v-if="!$v.personne.nom.required">
                      الإسم العائلي
                      ضروري
                    </span>
                    <span class="md-error" v-else-if="!$v.personne.nom.minlength">
                      الإسم الذي أدخلته
                      لا يوجد
                    </span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field :class="getValidationClass('tel')">
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;" >رقم الهاتف</label>
                    <md-input type="tel" v-model="personne.tel" :disabled="sending"></md-input>
                    <span class="md-error" v-if="!$v.personne.tel.required">رقم الهاتف ضروري</span>
                    <span class="md-error" v-else-if="!$v.personne.tel.numeric">
                      رقم الهاتف لا يمكن
                      أن يحتوي على حروف
                    </span>
                    <span class="md-error" v-else-if="!$v.personne.tel.minlength">
                      رقم الهاتف لا يمكن
                      أن يحتوي على أقل من عشر أرقام
                    </span>
                    <span class="md-error" v-else-if="!$v.personne.tel.maxlength">
                      رقم الهاتف لا يمكن
                      أن يحتوي على أكتر من عشر أرقام
                    </span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-65">
                  <md-field :class="getValidationClass('adresse')">
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">العنوان</label>
                    <md-input type="text" v-model="personne.adresse" :disabled="sending"></md-input>
                    <span class="md-error" v-if="!$v.personne.adresse.required">العنوان ضروري</span>
                    <span class="md-error" v-else-if="!$v.personne.adresse.minlength">
                      عنوان
                      خاطئ
                    </span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field>
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">الرقم الضريبي</label>
                    <md-input
                      type="text"
                      v-model="client.identification_fiscale"
                      :disabled="sending"
                    ></md-input>
                  </md-field>
                </div>

                <div class="md-layout-item md-size-100 text-right">
                  <md-button type="submit" style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;" class="md-raised md-success">إضافة</md-button>
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
  name: "ajouter-client",
  mixins: [validationMixin],
  props: {
    dataBackgroundColor: {
      type: String,
      default: ""
    }
  },
  created() {
    
  },
  data() {
    return {
      personne: {
        nom: "",
        prenom: "",
        tel: "",
        adresse: "",
        photo: "",
        photocopie_carte_national: ""
      },
      clients: [],
      client: {
        identification_fiscale: "",
        personne_id: "",
      },
      sending: false,
      token : localStorage.getItem('token'),
    };
  },
  validations: {
    personne: {
      nom: {
        required,
        minLength: minLength(3),
      },
      prenom: {
        required,
        minLength: minLength(3),
      },
      tel: {
        required,
        minLength: minLength(10),
        maxLength: maxLength(10),
        numeric
      },
      adresse: {
        required,
        minLength: minLength(3)
      }
    }
  },
  methods: {
    getValidationClass(fieldName) {
      const field = this.$v.personne[fieldName];

      if (field) {
        return {
          "md-invalid": field.$invalid && field.$dirty
        };
      }
    },
    getValidationClass2(fieldName) {
      const field = this.$v.client[fieldName];

      if (field) {
        return {
          "md-invalid": field.$invalid && field.$dirty
        };
      }
    },
    addClient() {
        this.$v.$touch();
        if (!this.$v.$invalid) {
          this.sending = true;
          //this.charge.type_charge_id = this.selected;
          console.log(this.client);
          fetch("api/personne", {
            method: "post",
            body: JSON.stringify(this.personne),
            headers: {
              "content-type": "application/json"
            }
          })
          .then(res => res.json())
            .then(data => {
               this.client.personne_id = data.data.id;
                fetch("api/client?token="+this.token, {
            method: "post",
            body: JSON.stringify(this.client),
            headers: {
              "content-type": "application/json"
            }
          })
            .then(res => res.json())
            .then(data => {
              this.$router.push({ name: 'ListeClients' });
            })
            .catch(err => console.log(err));
            })
            .catch(err => console.log(err));
        }
    }
  }
};
</script>


<style>
</style>