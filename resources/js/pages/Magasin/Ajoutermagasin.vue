<template>
  <div class="content">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <div class="md-layout">
      
        <md-button
          style="font-size: 16px;"
          class="md-success"
          type="button"
          data-toggle="modal"
          data-target="#exampleModal"
        >
          <md-icon>add</md-icon>إضافة
        </md-button>
        <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
        <md-card>
          <md-card-header data-background-color="green">
            <h4 class="title">قائمة المحلات : </h4>
            <p class="category"></p>
          </md-card-header>
          <md-card-content>
             <md-table v-model="magasins" table-header-color="green">
              <md-table-row slot="md-table-row" slot-scope="{ item }">
                <md-table-cell md-label="الاسم">{{ item.nom }}</md-table-cell>
                <md-table-cell md-label="رقم الترخيص" >{{ item.numero_de_patente }}</md-table-cell>
                <md-table-cell md-label="ر.س">{{ item.rc}}</md-table-cell>

                <md-table-cell md-label="رقم البطاقة البنكية">{{ item.numero_compte_bancaire }}</md-table-cell>
                <md-table-cell md-label="اختيار">
                  
                  <md-button
                     @click="lancerModal(item)"
                     data-toggle="modal"
                     data-target="#exampleModal2"
                     class="md-warning md-just-icon md-round"
                    
                  >
                    <md-icon>edit</md-icon>
                  </md-button>
                  <md-button
                    @click="destroyFournisseur(item.id, item.personne.id)"
                    class="md-danger md-just-icon md-round"
                  >
                    <md-icon>delete</md-icon>
                  </md-button>
                </md-table-cell>
              </md-table-row>
            </md-table>
          </md-card-content>
        </md-card>
      </div>
    </div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
      
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">  المرجو إدخال المعلومات التالية:</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" enctype="multipart/form-data">
            <md-field :class="getValidationClass('nom')">
            <md-input type="text"  v-model="magasin.nom" placeholder="الاسم"/>
            <span class="md-error" v-if="!$v.magasin.nom.required">الإسم العائلي ضروري</span>
            <span class="md-error" v-else-if="!$v.magasin.nom.minlength">الإسم الذي أدخلته لا يوجد</span>
            <span class="md-error" v-else-if="!$v.magasin.nom.alpha">الإسم لا يحتوي على أرقام</span>
            </md-field>
            <md-field :class="getValidationClass('numero_de_patente')">
            <input type="text" class="form-control mb-4" v-model="magasin.numero_de_patente" placeholder="رقم الترخيص" />
            <span class="md-error" v-if="!$v.magasin.numero_de_patente.required">رقم الترخيص ضروري</span>
            <span class="md-error" v-else-if="!$v.magasin.numero_de_patente.numeric"> رقم الترخيص لا يمكن أن يحتوي على حروف</span>
            </md-field>
            <md-field :class="getValidationClass('rc')">
            <input type="text" class="form-control mb-4" v-model="magasin.rc" placeholder="ر.س" />
            <span class="md-error" v-if="!$v.magasin.rc.required"> ضروري</span>
            <span class="md-error" v-else-if="!$v.magasin.rc.minlength"> خاطئ</span>
            </md-field>
            <md-field :class="getValidationClass('numero_compte_bancaire')">
            <input type="text" class="form-control mb-4" v-model="magasin.numero_compte_bancaire" placeholder="رقم البطاقة البنكية" />
            <span class="md-error" v-if="!$v.magasin.numero_compte_bancaire.required">رقم البطاقة البنكية ضروري</span>
            <span class="md-error" v-else-if="!$v.magasin.numero_compte_bancaire.numeric">رقم البطاقة البنكية لا يمكن أن يحتوي على حروف</span>
            </md-field>
          </div>

          <div class="modal-footer">
            <button
              type="button"
              @click="addMagasin()"
              :data-dismiss="modal"
            
            class="btn btn-success"
              style="margin-top : -15px;border-color: #4caf50;background-color: #4caf50 !important;"
            >حفظ</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">خروج</button>
          </div>
        </div>
      </div>
    </div>
     <!-- Modal2 -->
    <div
      class="modal fade"
      id="exampleModal2"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">  المرجو إدخال المعلومات التالية:</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
           
            <input type="text" class="form-control mb-4" v-model="magasin.nom" placeholder="الاسم " />
            
            <input type="text" class="form-control mb-4" v-model="magasin.numero_de_patente" placeholder="رقم الترخيص " />
            <input type="text" class="form-control mb-4" v-model="magasin.rc" placeholder="ر.س" />
            <input type="text" class="form-control mb-4" v-model="magasin.numero_compte_bancaire" placeholder="رقم البطاقة البنكية" />
          </div>

          <div class="modal-footer">
            <button
              type="button"
              data-dismiss="modal"
              class="btn btn-success"
              
              @click="updateMagasin()"
              style="margin-top : -15px;border-color: #4caf50;background-color: #4caf50 !important;"
            >حفظ</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">خروج</button>
          </div>
        </div>
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
   name: "magasins",
   mixins: [validationMixin],
  props: {
    tableHeaderColor: {
      type: String,
      default: ""
    }
  },
  data() {
    return {
       magasins: [],
      magasin:{
          user_id:'2',
          nom:'',
          numero_de_patente:'',
          rc:'',
          numero_compte_bancaire:''
      },
      sending: false,
      modal: ""
    };
  },
   validations: {
      magasin: {
        nom: {
          required,
          minLength: minLength(3)
        },
        numero_de_patente: {
          required,
          minLength: minLength(3)
        },
        rc: {
          required,
          minLength: minLength(3)
        },
        numero_compte_bancaire: {
          required,
          minLength: minLength(3)
        }

      },
      
    },

    created() {
    this.fetchMagasins();
  },
  methods: {
       getValidationClass(fieldName) {
        const field = this.$v.magasin[fieldName]

        if (field) {
          return {
            'md-invalid': field.$invalid && field.$dirty
          }
        }},
    
  
      fetchMagasins() {
      const token = localStorage.getItem('token');
      fetch("/api/magasins?token="+token)
        .then(res => res.json())
        .then(res => {
          this.magasins = res.data;
        })
        .catch(err => console.log(err));
    },
    lancerModal(item) {
        this.magasin.id = item.id;
        this.magasin.nom = item.nom;
        this.magasin.numero_de_patente = item.numero_de_patente;
        this.magasin.rc = item.rc;
        this.magasin.numero_compte_bancaire=item.numero_compte_bancaire;

      },
    addMagasin() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.sending = true;
        this.bool=false;
        const token = localStorage.getItem('token');
       fetch('api/magasin?token='+token, {
            method: "post",
            body: JSON.stringify(this.magasin),
            headers: {
              "content-type": "application/json"
            }

          })
            .then(res => res.json())
            .then(res => {
              this.modal="modal";
              this.fetchMagasins();
            })
            .catch(err => console.log(err));
      /*
     let currentObject = this;
      const config = {
        headers: {
          'content-type': 'multipart/form-data'
        }
      };
      let formData = new FormData();
      formData.append('nom', this.magasin.nom);
       formData.append('user_id',1);
      formData.append('numero_de_patente', this.magasin.numero_de_patente);
      formData.append('rc', this.magasin.rc);
      formData.append('numero_compte_bancaire', this.magasin.numero_compte_bancaire);
      axios.post('api/magasin', formData, config)
     .then(function(response) {
       currentObject.magasin.user_id = response.data.data.id;
       fetch("api/magasin", {
            method: "post",
            body: JSON.stringify(currentObject.magasin),
            headers: {
              "content-type": "application/json"
            }
          })
            .then(res => res.json())
            .then(data => {
              alert("Magasin Added");
              currentObject.$router.push({name:'magasin'});
            })
            .catch(err => console.log(err));
     })
     .catch(function(error) {
       console.log(error);
     });
  */}},
  
    updateMagasin() {
      //
      fetch(`api/magasin/${this.magasin.id}`, {
          method: "put",
          body: JSON.stringify(this.magasin),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(res => {
            this.fetchMagasins();
            this.modal = false;
          })
          .catch(err => console.log(err));
      },
      //


      /* let currentObject = this;
       //console.log($currentObject.magasin.id);
      fetch(`api/magasin/${this.magasin.id}`, {
            method: "put",
            body: JSON.stringify(this.magasin),
            headers: {
              "content-type": "application/json"
            }

          })
            .then(res => res.json())
            .then(res => {
              this.$router.push({ name: 'magasin' });
            })
            .catch(err => console.log(err));
  } */

  },
 //UPDATE
  
  
};
</script>
  