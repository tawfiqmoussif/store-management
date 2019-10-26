<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-size-66">
        <form novalidate @submit.prevent="addUser" enctype="multipart/form-data">
          <md-card>
            <md-card-header data-background-color="green">
              <h4 class="title">المستعملين</h4>
              <p class="category">حساب المستعمل</p>
            </md-card-header>

            <md-card-content>
              <div class="md-layout md-gutter">
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field :class="getValidationClass('prenom')">
                    <label
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    >الإسم الشخصي</label>
                    <md-input type="text" v-model="personne.prenom" :disabled="sending"></md-input>
                    <span class="md-error" v-if="!$v.personne.prenom.required">الإسم الشخصي ضروري</span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field :class="getValidationClass('nom')">
                    <label
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    >الإسم العائلي</label>
                    <md-input type="text" v-model="personne.nom" :disabled="sending"></md-input>
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
                    <span
                      class="md-error"
                      v-else-if="!$v.personne.tel.numeric"
                    >رقم الهاتف لا يمكن أن يحتوي على حروف</span>
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
                  <md-field :class="getValidationClass2('email')">
                    <label
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    >الإيميل</label>
                    <md-input type="email" v-model="user.email" :disabled="sending"></md-input>
                    <span class="md-error" v-if="!$v.user.email.required">الإيميل ضروري</span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field>
                    <label
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;display: inline-block !important; float: left !important;clear: left !important;width: 100px !important; text-align: right !important;"
                    >الوظيفة</label>
                    <md-select v-model="user.role">
                      <md-option value="2">admin</md-option>
                      <md-option value="3">secrétaire</md-option>
                    </md-select>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field>
                    <label
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    >إسم المحل</label>
                    <md-input type="text" v-model="user.magasin.nom" :disabled="sending"></md-input>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field>
                    <label
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    >رقم الترخيص</label>
                    <md-input
                      type="text"
                      v-model="user.magasin.numero_de_patente"
                      :disabled="sending"
                    ></md-input>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field>
                    <label
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    >رقم البطاقة البنكية</label>
                    <md-input
                      type="text"
                      v-model="user.magasin.numero_compte_bancaire"
                      :disabled="sending"
                    ></md-input>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field>
                    <label
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    >ر.س</label>
                    <md-input type="text" v-model="user.magasin.rc" :disabled="sending"></md-input>
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
export default {
  name: "ajouter-user",
  mixins: [validationMixin],
  props: {
    dataBackgroundColor: {
      type: String,
      default: ""
    }
  },
  created() {},
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
      users: [],
      user: {
        email: "",
        personne_id: "",
        role: "",
        magasin: {
          nom: "",
          numero_de_patente: "",
          rc: "",
          numero_compte_bancaire: ""
        }
      },
      sending: false
    };
  },
  validations: {
    personne: {
      nom: {
        required
      },
      prenom: {
        required
      },
      tel: {
        required,
        numeric
      },
      adresse: {
        required
      }
    },
    user: {
      email: {
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
      const field = this.$v.user[fieldName];

      if (field) {
        return {
          "md-invalid": field.$invalid && field.$dirty
        };
      }
    },
    addUser() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.sending = true;
        fetch("api/personne", {
          method: "post",
          body: JSON.stringify(this.personne),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {
            this.user.personne_id = data.data.id;
            fetch("api/user", {
              method: "post",
              body: JSON.stringify(this.user),
              headers: {
                "content-type": "application/json"
              }
            })
              .then(data => {
                this.$router.push({ name: "ListeUsers" });
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