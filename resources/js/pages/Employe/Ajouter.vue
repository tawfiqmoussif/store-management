<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-size-66">
        <form novalidate @submit.prevent="addEmploye" enctype="multipart/form-data">
          <md-card>
            <md-card-header data-background-color="green">
              <h4 style="font-weight: regular;" class="title">المستخدمين</h4>
              <p style="font-size:20px;font-weight: bold;" class="category">حساب المستخدم</p>
            </md-card-header>

            <md-card-content>
              <div class="md-layout  md-gutter">
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
                    <span class="md-error" v-if="!$v.personne.nom.required">الإسم العائلي ضروري</span>
                    <span
                      class="md-error"
                      v-else-if="!$v.personne.nom.minlength"
                    >الإسم الذي أدخلته لا يوجد</span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field :class="getValidationClass('tel')">
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">رقم الهاتف</label>
                    <md-input type="tel" v-model="personne.tel" :disabled="sending"></md-input>
                    <span class="md-error" v-if="!$v.personne.tel.required">رقم الهاتف ضروري</span>
                    <span
                      class="md-error"
                      v-else-if="!$v.personne.tel.numeric"
                    >رقم الهاتف لا يمكن أن يحتوي على حروف</span>
                    <span
                      class="md-error"
                      v-else-if="!$v.personne.tel.minlength"
                    >رقم الهاتف خاطئ</span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-65">
                  <md-field :class="getValidationClass('adresse')">
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">العنوان</label>
                    <md-input type="text" v-model="personne.adresse" :disabled="sending"></md-input>
                    <span class="md-error" v-if="!$v.personne.adresse.required">العنوان ضروري</span>
                    <span class="md-error" v-else-if="!$v.personne.adresse.minlength">عنوان خاطئ</span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field>
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">نسخة بطاقة التعريف الوطنية</label>
                    <md-file @change="onImageChange1" />
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field>
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">الصورة الشخصية</label>
                    <md-file @change="onImageChange2" />
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field>
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"  class="text-left">تاريخ العمل</label>
                    <md-input type="date" v-model="employe.date_recrutement"></md-input>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field :class="getValidationClass2('salaire')">
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">الأجرة اليومية</label>
                    <md-input type="text" v-model="employe.salaire" :disabled="sending"></md-input>
                    <span class="md-error" v-if="!$v.employe.salaire.required">الأجرة ضرورية</span>
                    <span
                      class="md-error"
                      v-else-if="!$v.employe.salaire.numeric"
                    >الأجرة لا يمكن أن تحتوي على حروف</span>
                  </md-field>
                </div>

                <div class="md-layout-item md-size-100 text-right">
                  <md-button type="submit" style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;" class="md-raised md-success">إضافة</md-button>
                </div>
              </div>
            </md-card-content>
            <md-progress-bar md-mode="indeterminate" v-if="sending" />
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
  name: "ajouter-employe",
  mixins: [validationMixin],
  props: {
    dataBackgroundColor: {
      type: String,
      default: ""
    }
  },
  created() {
    this.employe.date_recrutement = this.formatDate(new Date());
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
      employes: [],
      employe: {
        date_recrutement: null,
        salaire: "",
        personne_id: ""
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
        minLength: maxLength(10),
        numeric
      },
      adresse: {
        required,
        minLength: minLength(3)
      }
    },
    employe: {
      salaire: {
        required,
        numeric
      }
    }
  },
  methods: {
    onImageChange1(e) {
      this.personne.photocopie_carte_national = e.target.files[0];
    },
    onImageChange2(e) {
      this.personne.photo = e.target.files[0];
    },
    getValidationClass(fieldName) {
      const field = this.$v.personne[fieldName];

      if (field) {
        return {
          "md-invalid": field.$invalid && field.$dirty
        };
      }
    },
    getValidationClass2(fieldName) {
      const field = this.$v.employe[fieldName];

      if (field) {
        return {
          "md-invalid": field.$invalid && field.$dirty
        };
      }
    },
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
    addEmploye() {
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
        formData.append("photoF", this.personne.photo);
        formData.append(
          "photocopie_carte_nationalF",
          this.personne.photocopie_carte_national
        );
        formData.append("nom", this.personne.nom);
        formData.append("prenom", this.personne.prenom);
        formData.append("adresse", this.personne.adresse);
        formData.append("tel", this.personne.tel);
        axios
          .post("api/personne", formData, config)
          .then(function(response) {
            currentObject.employe.personne_id = response.data.data.id;
            fetch("api/employe?token="+currentObject.token, {
              method: "post",
              body: JSON.stringify(currentObject.employe),
              headers: {
                "content-type": "application/json"
              }
            })
              .then(res => res.json())
              .then(data => {
                currentObject.$router.push({ name: "employes" });
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

<style lang="scss" scoped>
  .md-progress-bar {
    position: absolute;
    top: -100;
    right: 0;
    left: 0;
  }
</style>