<template>
  <div class="content">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <div class="md-layout">
      <md-button class="md-success md-just-icon md-round" to="/Add"> <md-icon>add</md-icon></md-button>
      <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
        <md-card>
          <md-card-header data-background-color="green">
            <h4 class="title">قائمة البائعين</h4>
            <p class="category"></p>
            <div class="row" style=" margin-top:10px;">
              <div class="md-layout-item md-small-size-100 md-size-20">
                <input
                  type="text"
                  v-model="prenom"
                  placeholder="الإسم الشخصي"
                  class="form-control mb-4"
                />
              </div>
              <div class="md-layout-item md-small-size-100 md-size-20">
                <input
                  type="text"
                  v-model="nom"
                  placeholder="الإسم العائلي"
                  class="form-control mb-4"
                />
              </div>
            </div>
          </md-card-header>
          <md-card-content>
            <md-table class="table-responsive" v-model="paginedFournisseur" table-header-color="green">
              <md-table-row slot="md-table-row" slot-scope="{ item }">
                <md-table-cell  md-label="الاسم الشخصي">{{ item.personne.prenom }}</md-table-cell>
                <md-table-cell md-label="الاسم العائلي">{{ item.personne.nom }}</md-table-cell>
                <md-table-cell md-label="الهاتف">{{ item.personne.tel}}</md-table-cell>

                <md-table-cell md-label="العنوان">{{ item.personne.adresse }}</md-table-cell>

                <md-table-cell md-label="تحديد الضريبة">{{ item.id_fiscale }}</md-table-cell>
                <md-table-cell md-label="اسم العلامة التجارية">{{ item.nom_marque }}</md-table-cell>
                <md-table-cell md-label="اختيار">
                  <md-button @click="toSal(item)" class="md-rose md-just-icon md-round">
                    <md-icon class="fa fa-dollar-sign"></md-icon>
                  </md-button>
                  <md-button
                    :to="{name: 'modifierFour',params: {fournisseur: item}}"
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
          <!--sommeFournisseur-->
        </md-card>
        <div
          class="md-layout-item md-small-size-100 md-size-40"
          style="margin : 0 auto;display: flex;justify-content: center;"
        >
         
          <mdb-btn style="border-color: #4caf50;background-color: #4caf50 !important;" color="success" :disabled="page === 0" @click="prec()"> <i class="fas fa-forward"></i>
            السابق
          </mdb-btn>
        <p style="margin-top: 20px;" v-if="this.filtred.length>0"> {{ page + 1 }} من {{ Math.ceil(this.filtred.length/this.itemsPerPage) }}</p>
         
           <mdb-btn
            style="border-color: #4caf50;background-color: #4caf50 !important;"
            color="success"
            :disabled="page === Math.ceil(this.filtred.length/this.itemsPerPage)-1 || this.filtred.length==0"
            @click="suiv()"
          >
            التالي <i class="fas fa-backward"></i>
          </mdb-btn>
        </div>
         <mdb-modal :show="modalFournisseur" @close="modalFournisseur = false">
          <mdb-modal-header>
            <mdb-modal-title></mdb-modal-title>
          </mdb-modal-header>
          <mdb-modal-body>
                  <mdb-tbl bordered>
                    <mdb-tbl-head color="light">
                      <tr>
                        <th> الواجب علي</th>
                        <th>الواجب عليه</th>
                      </tr>
                    </mdb-tbl-head>
                    <mdb-tbl-body>
                      <tr>
                        <td>
                          {{sommeClient}}
                        </td>
                        <td> 
                          {{sommeFournisseur}}
                        </td>
                      </tr>
                    </mdb-tbl-body>
                  </mdb-tbl>
          </mdb-modal-body>
          <mdb-modal-footer>
            <mdb-btn color="secondary" style="margin :10px;" @click.native="modalFournisseur = false">إغلاق</mdb-btn>
          </mdb-modal-footer>
        </mdb-modal>
        <!---->
      </div>
    </div>
  </div>
</template>

<script>
import {
   mdbTbl,
  mdbTblHead,
  mdbTblBody,
  mdbScrollbar,
  mdbModal,
  mdbModalHeader,
  mdbModalTitle,
  mdbModalBody,
  mdbModalFooter,
  mdbBtn
} from "mdbvue";
export default {
  components: {
      mdbTbl,
    mdbTblHead,
    mdbTblBody,
    mdbScrollbar,
    mdbModal,
    mdbModalHeader,
    mdbModalTitle,
    mdbModalBody,
    mdbModalFooter,
    mdbBtn
  },
  name: "liste-fournisseurs",
  props: {
    tableHeaderColor: {
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
        adresse: "",
        photo: null,
        photocopie_carte_national:null
      },
      fournisseurs: [],
      fournisseur: {
        personne_id: "",
        id_fiscale: "",
        nom_marque: ""
      },
      active: false,
      value: null,
      token : localStorage.getItem('token'),
      sommeClient: "",
      sommeFournisseur: "",
      modalFournisseur: false,
       nom: "",
      prenom: "",
       page: 0,
      itemsPerPage: 2
    };
  },
  created() {
    this.fetchFournisseurs();
  },
  methods: {
    suiv() {
      this.page = this.page + 1;
    },
    prec() {
      this.page = this.page - 1;
    },
    paginate() {
      return this.filtred.slice(
        this.page * this.itemsPerPage,
        this.itemsPerPage * this.page + this.itemsPerPage
      );
    },
    toSal(fournisseur) {
      fetch(`/api/sommeFourisseur/${fournisseur.id}?token=` + this.token)
        .then(res => res.json())
        .then(res => {
          this.sommeClient = res.sommeClient;
          this.sommeFournisseur = res.sommeFournisseur;
          this.modalFournisseur = true;
        })
        .catch(err => console.log(err));
    },
    fetchFournisseurs() {
      fetch("/api/fournisseurs?token="+this.token)
        .then(res => res.json())
        .then(res => {
          this.fournisseurs = res.data;
        })
        .catch(err => console.log(err));
    },
    destroyFournisseur(idFour, idPers) {
      if (confirm("Vous etes sur ?")) {
        fetch(`/api/fournisseur/${idFour}`, {
          method: "delete"
        })
          .then(res => res.json())
          .then(res => {
            alert("Fournisseur removed");
            fetch(`/api/personne/${idPers}`, {
              method: "delete"
            })
              .then(res => res.json())
              .then(res => {
                created();
              })
              .catch(err => console.log(err));
          })
          .catch(err => console.log(err));
      }
    }
  },
   computed: {
    filtred: function() {
      let currentObject = this;
      return this.fournisseurs.filter(function(item) {
        return (
          item.personne.nom.includes(currentObject.nom) &&
          item.personne.prenom.includes(currentObject.prenom)
        );
      });
    },
    paginedFournisseur() {
      return this.filtred.slice(
        this.page * this.itemsPerPage,
        this.itemsPerPage * this.page + this.itemsPerPage
      );
    }
  }
};
</script>


















