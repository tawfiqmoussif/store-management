<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-size-66">
        <form novalidate @submit.prevent="updateFournisseur" enctype="multipart/form-data">
          <md-card>
            <md-card-header data-background-color="green">
              <h4 class="title">البائعون</h4>
              <p class="category">حساب البائع</p>
            </md-card-header>

            <md-card-content>
              <div class="md-layout">
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field :class="getValidationClass('prenom')">
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">الاسم الشخصي</label>
                    <md-input type="text" v-model="fournisseur.personne.prenom" :disabled="sending"></md-input>
                    <span class="md-error" v-if="!$v.fournisseur.personne.prenom.required">الإسم الشخصي ضروري</span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field :class="getValidationClass('nom')">
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">الاسم العائلي</label>
                    <md-input type="text" v-model="fournisseur.personne.nom" :disabled="sending"></md-input>
                     <span class="md-error" v-if="!$v.fournisseur.personne.nom.required">الإسم العائلي ضروري</span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field :class="getValidationClass('tel')">
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">رقم الهاتف</label>
                    <md-input type="tel" v-model="fournisseur.personne.tel" :disabled="sending"></md-input>
                    <span class="md-error" v-if="!$v.fournisseur.personne.tel.required">رقم الهاتف ضروري</span>
                    <span class="md-error" v-else-if="!$v.fournisseur.personne.tel.numeric">رقم الهاتف لا يمكن أن يحتوي على حروف</span>
                    <span class="md-error" v-else-if="!$v.fournisseur.personne.tel.minlength">رقم الهاتف لا يمكن أن يحتوي على أقل من عشر أرقام</span>
                    <span class="md-error" v-else-if="!$v.fournisseur.personne.tel.maxlength">رقم الهاتف لا يمكن أن يحتوي على أكتر من عشر أرقام</span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-65">
                  <md-field :class="getValidationClass('adresse')">
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">العنوان</label>
                    <md-input type="text" v-model="fournisseur.personne.adresse" :disabled="sending"></md-input>
                    <span class="md-error" v-if="!$v.fournisseur.personne.adresse.required">العنوان ضروري</span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field :class="getValidationClass2('id_fiscale')">
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">تحديد الضريبة</label>
                    <md-input type="text" v-model="fournisseur.id_fiscale" :disabled="sending"></md-input>
                    <span class="md-error" v-if="!$v.fournisseur.id_fiscale.required"> تحديد الضريبة ضروري</span>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field :class="getValidationClass2('id_fiscale')">
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">إسم العلامة التجارية</label>
                    <md-input type="text" v-model="fournisseur.nom_marque" :disabled="sending"></md-input>
                    <span class="md-error" v-if="!$v.fournisseur.nom_marque.required">إسم العلامة التجارية ضروري</span>
                  </md-field>
                </div>

                <div class="md-layout-item md-size-100 text-right">
                  <md-button style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;" type="submit" class="md-raised md-success" :disabled="sending">تعديل</md-button>
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
import { validationMixin } from 'vuelidate'
  import {
    required,
    minLength,
    maxLength,
    numeric,
    alpha
  } from 'vuelidate/lib/validators'

export default {
    name: "modifier-fournisseur",
    mixins: [validationMixin],
  props: {
    dataBackgroundColor: {
      type: String,
      default: ""
    }
  },
  data() {
    return {
      fournisseur: new Object(),
      fournisseurT: {
        id_fiscale: "",
        nom_marque: "",
        personne_id: ""
      },
      sending: false,
      changePh: 0,
      changePhC: 0
    };
  },
  created() {
    this.fournisseur = this.$route.params.fournisseur;
  },
  validations: {
 
      fournisseur: { 
             personne: {
        prenom: {
          required
        },
        nom: {
          required
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
        id_fiscale: {
          required
        },
        nom_marque: {
          required
        }
      }
    },
  methods: {

   getValidationClass (fieldName) {
        const field = this.$v.fournisseur.personne[fieldName]

        if (field) {
          return {
            'md-invalid': field.$invalid && field.$dirty
          }
        }},
        
     getValidationClass2 (fieldName) {
        const field = this.$v.fournisseur[fieldName]

        if (field) {
          return {
            'md-invalid': field.$invalid && field.$dirty
          }
        }},

    updateFournisseur() {
      this.$v.$touch();

      if (!this.$v.$invalid) {
        
      this.fournisseurT = new Object();
      this.fournisseurT.id_fiscale = this.fournisseur.id_fiscale;
      this.fournisseurT.nom_marque = this.fournisseur.nom_marque;
      //
      let currentObject = this;
      const config = {
        headers: {
          "content-type": "multipart/form-data"
        }
      };
      let formData = new FormData();
      formData.append("id", this.fournisseur.id);
      formData.append("nom", this.fournisseur.personne.nom);
      formData.append("prenom", this.fournisseur.personne.prenom);
      formData.append("adresse", this.fournisseur.personne.adresse);
      formData.append("tel", this.fournisseur.personne.tel);
      formData.append("changePh", this.changePh);
      formData.append("changePhC", this.changePhC);
      axios
        .post("api/personneU", formData, config)
        .then(function(response) {
          currentObject.fournisseurT.personne_id = response.data.data.id;
          currentObject.fournisseurT.magasin_id = 1;
          fetch(`api/fournisseur/${currentObject.fournisseur.id}`, {
            method: "put",
            body: JSON.stringify(currentObject.fournisseurT),
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
        });}
    }
  }
};
</script>


<style>
</style>
