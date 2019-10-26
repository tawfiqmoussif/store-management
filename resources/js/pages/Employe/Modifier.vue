<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-size-66">
        <form @submit.prevent="updateEmploye" enctype="multipart/form-data">
          <md-card>
            <md-card-header data-background-color="green">
              <h4 style="font-weight: regular;" class="title">المستخدمين</h4>
              <p style="font-size:20px;font-weight: bold;" class="category">حساب المستخدم</p>
            </md-card-header>

            <md-card-content>
              <div class="md-layout md-gutter">
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field :class="getValidationClass('prenom')">
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">الاسم الشخصي</label>
                    <md-input type="text" v-model="employe.personne.prenom" :disabled="sending"></md-input>
                  <span class="md-error" v-if="!$v.employe.personne.prenom.required">الإسم الشخصي ضروري</span>
                    <span
                      class="md-error"
                      v-else-if="!$v.employe.personne.prenom.minlength"
                    >الإسم الذي أدخلته لا يوجد</span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field :class="getValidationClass('nom')">
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">الاسم العائلي</label>
                    <md-input type="text" v-model="employe.personne.nom" :disabled="sending"></md-input>
                    <span class="md-error" v-if="!$v.employe.personne.nom.required">الإسم العائلي ضروري</span>
                    <span
                      class="md-error"
                      v-else-if="!$v.employe.personne.nom.minlength"
                    >الإسم الذي أدخلته لا يوجد</span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field :class="getValidationClass('tel')">
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">رقم الهاتف</label>
                    <md-input type="tel" v-model="employe.personne.tel" :disabled="sending"></md-input>
                   <span class="md-error" v-if="!$v.employe.personne.tel.required">رقم الهاتف ضروري</span>
                    <span
                      class="md-error"
                      v-else-if="!$v.employe.personne.tel.numeric"
                    >رقم الهاتف لا يمكن أن يحتوي على حروف</span>
                    <span
                      class="md-error"
                      v-else-if="!$v.employe.personne.tel.minlength"
                    >رقم الهاتف خاطئ</span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-65">
                  <md-field :class="getValidationClass('adresse')">
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">العنوان</label>
                    <md-input type="text" v-model="employe.personne.adresse" :disabled="sending"></md-input>
                     <span class="md-error" v-if="!$v.employe.personne.adresse.required">العنوان ضروري</span>
                    <span class="md-error" v-else-if="!$v.employe.personne.adresse.minlength">عنوان خاطئ</span>
                 
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
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">تاريخ العمل</label>
                    <md-input type="date" v-model="employe.date_recrutement"></md-input>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field :class="getValidationClass2('salaire')">
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">الأجرة</label>
                    <md-input type="text" v-model="employe.salaire" :disabled="sending"></md-input>
                    <span class="md-error" v-if="!$v.employe.salaire.required">الأجرة ضرورية</span>
                    <span
                      class="md-error"
                      v-else-if="!$v.employe.salaire.numeric"
                    >الأجرة لا يمكن أن تحتوي على حروف</span>
                  </md-field>
                </div>

                <div class="md-layout-item md-size-100 text-right">
                  <md-button type="submit" style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;" class="md-raised md-success">تعديل</md-button>
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
  props: {
    dataBackgroundColor: {
      type: String,
      default: ""
    }
  },
  mixins: [validationMixin],
  validations: {
    employe: {
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
    },
      salaire: {
        required,
        numeric
      }
    }
  },
  data() {
    return {
      employe: new Object(),
      employeT: {
        date_recrutement: null,
        salaire: "",
        personne_id: "",
        magasin_id: ""
      },
      changePh: 0,
      changePhC: 0,
      sending: false
    };
  },
  created() {
    this.employe = this.$route.params.employe;
  },
  methods: {
    getValidationClass(fieldName) {
      const field = this.$v.employe.personne[fieldName];

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
    onImageChange1(e) {
      this.changePhC = 1;
      this.employe.personne.photocopie_carte_national = e.target.files[0];
    },
    onImageChange2(e) {
      this.changePh = 1;
      this.employe.personne.photo = e.target.files[0];
    },
    updateEmploye() {
       this.$v.$touch();

      if (!this.$v.$invalid) {
        this.sending = true;
      this.employeT = new Object();
      this.employeT.date_recrutement = this.employe.date_recrutement;
      this.employeT.salaire = this.employe.salaire;
      //
      let currentObject = this;
      const config = {
        headers: {
          "content-type": "multipart/form-data"
        }
      };
      let formData = new FormData();
      formData.append("id", this.employe.personne.id);
      formData.append("photoF", this.employe.personne.photo);
      formData.append(
        "photocopie_carte_nationalF",
        this.employe.personne.photocopie_carte_national
      );
      formData.append("nom", this.employe.personne.nom);
      formData.append("prenom", this.employe.personne.prenom);
      formData.append("adresse", this.employe.personne.adresse);
      formData.append("tel", this.employe.personne.tel);
      formData.append("changePh", this.changePh);
      formData.append("changePhC", this.changePhC);
      axios
        .post("api/personneU", formData, config)
        .then(function(response) {
          currentObject.employeT.personne_id = response.data.data.id;
          currentObject.employeT.magasin_id = 1;
          fetch(`api/employe/${currentObject.employe.id}`, {
            method: "put",
            body: JSON.stringify(currentObject.employeT),
            headers: {
              "content-type": "application/json"
            }
          })
            .then(res => res.json())
            .then(data => {
              alert("Employe Added");
              //this.fetchUsers();
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


<style>
</style>
