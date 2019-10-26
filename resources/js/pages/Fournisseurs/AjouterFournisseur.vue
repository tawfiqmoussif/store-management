<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-size-66">
        <form novalidate @submit.prevent="addFournisseur" enctype="multipart/form-data">
          <md-card>
            <md-card-header data-background-color="green">
              <h4 class="title">البائعون</h4>
              <p class="category">حساب البائع</p>
            </md-card-header>

            <md-card-content>
              <div class="md-layout">
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field :class="getValidationClass('prenom')">
                    <label
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    >الاسم الشخصي</label>
                    <md-input type="text" v-model="personne.prenom" :disabled="sending"></md-input>
                    <span class="md-error" v-if="!$v.personne.prenom.required">الإسم الشخصي ضروري</span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field :class="getValidationClass('nom')">
                    <label
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    >الاسم العائلي</label>
                    <md-input type="text" v-model="personne.nom"></md-input>
                    <span class="md-error" v-if="!$v.personne.nom.required">الإسم العائلي ضروري</span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field :class="getValidationClass('tel')">
                    <label
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    >رقم الهاتف</label>
                    <md-input type="tel" v-model="personne.tel" :disabled="sending"></md-input>
                    <span class="md-error" v-if="!$v.personne.tel.required">رقم الهاتف ضروري</span>
                    <span class="md-error" v-else-if="!$v.personne.tel.numeric">
                      رقم الهاتف لا يمكن أن يحتوي على
                      حروف
                    </span>
                    <span class="md-error" v-else-if="!$v.personne.tel.minlength">
                      رقم الهاتف لا يمكن أن يحتوي على أقل من
                      عشر أرقام
                    </span>
                    <span class="md-error" v-else-if="!$v.personne.tel.maxlength">
                      رقم الهاتف لا يمكن أن يحتوي على أكتر
                      من عشر أرقام
                    </span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-65">
                  <md-field :class="getValidationClass('adresse')">
                    <label
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    >العنوان</label>
                    <md-input type="text" v-model="personne.adresse" :disabled="sending"></md-input>
                    <span class="md-error" v-if="!$v.personne.adresse.required">العنوان ضروري</span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field>
                    <label
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    >تحديد الضريبة</label>
                    <md-input type="text" v-model="fournisseur.identification_fiscale"></md-input>
                    </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field :class="getValidationClass2('nom_marque')">
                    <label
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    >اسم العلامة التجارية</label>
                    <md-input type="text" v-model="fournisseur.nom_marque"></md-input>
                    <span
                      class="md-error"
                      v-if="!$v.fournisseur.nom_marque.required"
                    >اسم العلامة التجارية ضروري</span>
                  </md-field>
                </div>

                <div class="md-layout-item md-size-100 text-right">
                  <md-button
                    style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    type="submit"
                    class="md-raised md-success"
                    :disabled="sending"
                  >إضافة</md-button>
                  <md-button
                    style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    class="md-raised md-success"
                    :disabled="sending"
                    @click="addAsClient()"
                  >إضافته كزبون</md-button>
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
  name: "ajouter-fournisseur",
  mixins: [validationMixin],
  props: {
    dataBackgroundColor: {
      type: String,
      default: ""
    }
  },
  data() {
    return {
      personne: {
        nom: "",
        prenom: "",
        tel: "",
        adresse: ""
      },
      fournisseurs: [],
      fournisseur: {
        personne_id: ""
      },
      sending: false,
      token: localStorage.getItem("token")
    };
  },

  validations: {
    personne: {
      prenom: {
        required,
        minLength: minLength(3)
      },
      nom: {
        required,
        minLength: minLength(3)
      },
      tel: {
        required,
        maxLength: maxLength(10),
        minLength: minLength(10)
      },
      adresse: {
        required
      }
    },
    fournisseur: {
      nom_marque: {
        required
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
      const field = this.$v.fournisseur[fieldName];

      if (field) {
        return {
          "md-invalid": field.$invalid && field.$dirty
        };
      }
    },
    addAsClient() {
      this.$v.$touch();

      if (!this.$v.$invalid) {
        this.sending = true;
        let currentObject = this;
        const config = {
          headers: {
            "content-type": "multipart/form-data"
          }
        };
        let formData = new FormData();
        formData.append("nom", this.personne.nom);
        formData.append("prenom", this.personne.prenom);
        formData.append("adresse", this.personne.adresse);
        formData.append("tel", this.personne.tel);
        axios
          .post("api/personne", formData, config)
          .then(function(response) {
            currentObject.fournisseur.personne_id = response.data.data.id;
            fetch("api/fournisseur?token=" + currentObject.token, {
              method: "post",
              body: JSON.stringify(currentObject.fournisseur),
              headers: {
                "content-type": "application/json"
              }
            })
              .then(res => res.json())
              .then(data => {
                fetch("api/client?token=" + currentObject.token, {
                  method: "post",
                  body: JSON.stringify(currentObject.fournisseur),
                  headers: {
                    "content-type": "application/json"
                  }
                })
                  .then(res => res.json())
                  .then(data => {
                     currentObject.$router.push({ name: "fournisseur" });
                  })
                  .catch(err => console.log(err));
               
              })
              .catch(err => console.log(err));
          })
          .catch(function(error) {
            console.log(error);
          });
      }
    },
    addFournisseur() {
      this.$v.$touch();

      if (!this.$v.$invalid) {
        this.sending = true;
        let currentObject = this;
        const config = {
          headers: {
            "content-type": "multipart/form-data"
          }
        };
        let formData = new FormData();
        formData.append("nom", this.personne.nom);
        formData.append("prenom", this.personne.prenom);
        formData.append("adresse", this.personne.adresse);
        formData.append("tel", this.personne.tel);
        axios
          .post("api/personne", formData, config)
          .then(function(response) {
            currentObject.fournisseur.personne_id = response.data.data.id;
            fetch("api/fournisseur?token=" + currentObject.token, {
              method: "post",
              body: JSON.stringify(currentObject.fournisseur),
              headers: {
                "content-type": "application/json"
              }
            })
              .then(res => res.json())
              .then(data => {
                currentObject.$router.push({ name: "fournisseur" });
              })
              .catch(err => console.log(err));
          })
          .catch(function(error) {
            console.log(error);
          });
      }
    }
  }
};
</script>


<style>
</style>