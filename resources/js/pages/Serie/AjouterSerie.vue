<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-size-66">
        <form novalidate @submit.prevent="addSerie" enctype="multipart/form-data">
          <md-card>
            <md-card-header data-background-color="green">
              <h4 style="font-weight: regular;" class="title">انواع البضاعة</h4>
              <p style="font-size:20px;font-weight: bold;" class="category">تدبير انواع البضاعة</p>
            </md-card-header>

            <md-card-content>
              <div class="md-layout">
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field :class="getValidationClass('ref')">
                    <label
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    >نوع البضاعة</label>
                    <md-input type="text" v-model="serie.ref"></md-input>
                    <span class="md-error" v-if="!$v.serie.ref.required">نوع البضاعة ضروري</span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field :class="getValidationClass('type_serie_id')">
                    <label
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;display: inline-block !important; float: left !important;clear: left !important;width: 100px !important; text-align: right !important;"
                    >نوع السيري</label>
                    <md-select v-model="serie.type_serie_id">
                      <md-option
                        v-for="type in types"
                        :key="type.id"
                        :value="type.id"
                      >{{type.libele}}</md-option>
                      <md-option color="primary" @click.native="modal = true">إضافة نوع جديد</md-option>
                    </md-select>
                    <span class="md-error" v-if="!$v.serie.type_serie_id.required">نوع السيري ضروري</span>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field :class="getValidationClass('fournisseur_id')">
                    <label
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;display: inline-block !important; float: left !important;clear: left !important;width: 80px !important; text-align: right !important;"
                    >المورد</label>
                    <md-select v-model="serie.fournisseur_id" :disabled="sending">
                      <md-option
                        v-for="fournisseur in fournisseurs"
                        :key="fournisseur.id"
                        :value="fournisseur.id"
                      >{{fournisseur.personne.nom}} {{fournisseur.personne.prenom}}</md-option>
                    </md-select>

                    <span
                      class="md-error"
                      v-if="!$v.serie.fournisseur_id.required"
                    >إختر المورد من فضلك</span>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-10">
                  <md-field :class="getValidationClass('from')">
                    <md-input
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                      type="text"
                      v-model="serie.from"
                      placeholder="من"
                    ></md-input>
                    <span class="md-error" v-if="!$v.serie.from.required">خطأ</span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-10">
                  <md-field :class="getValidationClass('to')">
                    <md-input
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                      type="text"
                      v-model="serie.to"
                      placeholder="إلى"
                    ></md-input>
                    <span class="md-error" v-if="!$v.serie.to.required">خطأ</span>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-60">
                  <label
                    style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                  >الصنف</label>

                  <md-checkbox
                    style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    v-model="serie.genre"
                    value="رجال"
                  >رجال</md-checkbox>
                  <md-checkbox
                    style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    v-model="serie.genre"
                    value="نساء"
                  >نساء</md-checkbox>
                  <md-checkbox
                    style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    v-model="serie.genre"
                    value="أطفال"
                  >أطفال</md-checkbox>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-40">
                  <md-field>
                    <label
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                      class="text-left"
                    >التاريخ</label>
                    <md-input type="date" v-model="Entree.date"></md-input>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field :class="getValidationClass('couleur')">
                    <label
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;display: inline-block !important; float: left !important;clear: left !important;width: 80px !important; text-align: right !important;"
                    >اللون</label>
                    <md-select v-model="serie.couleur">
                      <md-option value="أبيض" style="background-color:;height: 40px;">أبيض</md-option>
                      <md-option value="أسود" style="background-color:#000316;height: 40px;">أسود</md-option>
                      <md-option value="رمادي" style="background-color:#B7A8BA;height: 40px;">رمادي</md-option>
                      <md-option value="أحمر" style="background-color:#800000;height: 40px;">أحمر</md-option>
                      <md-option value="أصفر" style="background-color:#FFFF00;height: 40px;">أصفر</md-option>
                      <md-option value="أزرق" style="background-color:#0000FF;height: 40px;">أزرق</md-option>
                      <md-option value="وردي" style="background-color:#FF00FF;height: 40px;">وردي</md-option>
                    </md-select>
                    <span class="md-error" v-if="!$v.serie.couleur.required">إختر اللون من فضلك</span>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field>
                    <label
                      style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    >الصورة</label>
                    <md-file @change="onImageChange" />
                  </md-field>
                </div>
                <div class="md-layout-item md-size-100 text-right">
                  <md-button
                    type="submit"
                    style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    class="md-raised md-success"
                  >إضافة</md-button>
                  <md-button
                    @click="onExit"
                    style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                    class="md-raised md-success"
                  >التالي</md-button>
                </div>
              </div>
            </md-card-content>
            <md-progress-bar md-mode="indeterminate" v-if="sending2" />
          </md-card>
          <md-snackbar :md-active.sync="sending2">لقد تمت الإضافة بنجاح</md-snackbar>
        </form>
        <mdb-modal :show="modal" @close="modal = false">
          <mdb-modal-header>
            <mdb-modal-title>إضافة نوع جديد</mdb-modal-title>
          </mdb-modal-header>
          <mdb-modal-body>
            <input
              class="form-control form-control-lg"
              type="text"
              v-model="type_serie.libele"
              placeholder="نوع السيري"
            />
          </mdb-modal-body>
          <mdb-modal-footer>
            <mdb-btn @click="addTypeSerie()" color="primary">حفظ التغييرات</mdb-btn>
            <mdb-btn color="secondary" style="margin :10px;" @click.native="modal = false">إغلاق</mdb-btn>
          </mdb-modal-footer>
        </mdb-modal>
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
  name: "ajouter-serie",
  mixins: [validationMixin],
  props: {
    dataBackgroundColor: {
      type: String,
      default: ""
    }
  },
  data() {
    return {
      type_serie: {
        libele: ""
      },
      types: [],
      modal: false,
      selected: "",
      selectedColor: "",
      fournisseurs: null,
      series: [],
      serie: {
        fournisseur_id: "",
        magasin_id: "",
        type_serie_id: "",
        ref: "",
        couleur: "",
        genre: "",
        photo: "",
        from: "",
        to: ""
      },
      sending: false,
      sending2: false,
      Entree: {
        id_fournisseur: "",
        date: this.formatDate(new Date())
      },
      fournisseur: new Object(),
      token : localStorage.getItem('token')
    };
  },
  created() {
    this.remplirCombo();
    this.fetchFournisseurs();
  },
  validations: {
    serie: {
      ref: {
        required
      },
      from: {
        required
      },
      to: {
        required
      },
      type_serie_id: {
        required
      },
      fournisseur_id: {
        required
      },
      couleur: {
        required
      }
    }
  },
  methods: {
    onImageChange(e) {
      this.serie.photo = e.target.files[0];
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
    fetchFournisseurs() {
      fetch("/api/fournisseurs?token="+this.token)
        .then(res => res.json())
        .then(res => {
          this.fournisseurs = res.data;
        })
        .catch(err => console.log(err));
    },
    getValidationClass(fieldName) {
      const field = this.$v.serie[fieldName];

      if (field) {
        return {
          "md-invalid": field.$invalid && field.$dirty
        };
      }
    },
    remplirCombo() {
      fetch("/api/typeSeries?token="+this.token)
        .then(res => res.json())
        .then(res => {
          this.types = res.data;
          this.selected = this.types[0].id;
        })
        .catch(err => console.log(err));
    },
    addTypeSerie() {
      this.modal = false;
      fetch("api/typeSeries?token="+this.token, {
        method: "post",
        body: JSON.stringify(this.type_serie),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          this.remplirCombo();
        })
        .catch(err => console.log(err));

      //}
    },
    onExit() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        if (this.serie.genre == "") {
          this.$notification.error("المرجو إدخال الصنف", {
            timer: 10
          });
        } else {
          this.Entree.id_fournisseur = this.fournisseur.id;
          fetch("api/entree?token="+this.token, {
            method: "post",
            body: JSON.stringify(this.Entree),
            headers: {
              "content-type": "application/json"
            }
          })
            .then(res => res.json())
            .then(data => {
              let object = {
                Entree: data.data,
                Fournisseur: this.fournisseur
              };
              this.$router.push({ name: "ajouterEntree", params: { object } });
            })
            .catch(err => console.log(err));
        }
      }
    },
    addSerie() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        if (this.serie.genre == "") {
          this.$notification.error("المرجو إدخال الصنف", {
            timer: 10
          });
        }else{
            //////////////
        let data = {
          ref: this.serie.ref,
          fournisseur_id: this.serie.fournisseur_id,
          couleur: this.serie.couleur
        };
        fetch("api/existe?token="+this.token, {
          method: "post",
          body: JSON.stringify(data),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {
            if (data === 0) {
              this.sending = true;
              this.sending2 = true;
              let currentObject = this;
              const config = {
                headers: {
                  "content-type": "multipart/form-data"
                }
              };
              let formData = new FormData();
              formData.append("photo", this.serie.photo);
              formData.append("ref", this.serie.ref);
              formData.append("magasin_id", 1);
              formData.append("type_serie_id", this.serie.type_serie_id);
              formData.append("couleur", this.serie.couleur);
              formData.append("genre", this.serie.genre);
              formData.append("fournisseur_id", this.serie.fournisseur_id);
              axios
                .post("api/serie?token="+currentObject.token, formData, config)
                .then(function(response) {
                  currentObject.fournisseur = response.data.data.fournisseur;
                  currentObject.fournisseur.series = response.data.data.series;
                  let article = {
                    serie_id: response.data.data.id,
                    taille: "",
                    stock: 0
                  };
                  var i;
                  for (
                    i = currentObject.serie.from;
                    i <= currentObject.serie.to;
                    i++
                  ) {
                    article.taille = i;
                    fetch("api/article", {
                      method: "post",
                      body: JSON.stringify(article),
                      headers: {
                        "content-type": "application/json"
                      }
                    })
                      .then(res => res.json())
                      .then(data => {
                        currentObject.sending2 = false;
                      })
                      .catch(err => console.log(err));
                  }
                })
                .catch(function(error) {
                  console.log(error);
                });
            } else {
              this.$notification.error("لقد تمت إضافة هذا النوع سابقا", {
                timer: 10
              });
            }
          })
          .catch(err => console.log(err));

        ///////////////////////
        }
        
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