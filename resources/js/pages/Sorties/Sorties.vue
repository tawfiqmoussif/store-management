<template>
  <div class="content">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
        <md-button
          style="font-size: 16px;"
          class="md-success md-just-icon md-round"
          type="button"
          data-toggle="modal"
          data-target="#exampleModal"
        >
          <md-icon>add</md-icon>
        </md-button>
        <md-card>
          <md-card-header data-background-color="green">
            <h4 class="title">قائمة المبيعات :</h4>
            <p class="category"></p>

            <div class="row" style=" margin-top:10px;">
              <!--<div class="md-layout-item md-size-20">
                <md-autocomplete
                  v-model="nom"
                  :md-options="noms"
                  md-layout="box"
                  md-dense
                >
                  <label>الإسم الكامل</label>
                </md-autocomplete>
              </div>-->
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
              <div class="md-layout-item md-small-size-100 md-size-20">
                <input type="date" v-model="date" class="form-control mb-4" />
              </div>
              <div class="md-layout-item md-small-size-100 md-size-20">
                <input
                  type="text"
                  v-model="montant_total"
                  placeholder="الثمن الإجمالي"
                  class="form-control mb-4"
                />
              </div>
              <div class="md-layout-item md-small-size-100 md-size-20">
                <input
                  type="text"
                  v-model="nom_marque"
                  placeholder=" إسم العلامة التجارية "
                  class="form-control mb-4"
                  style="text-transform: capitalize"
                />
              </div>
            </div>
          </md-card-header>
          <md-card-content>
            <md-table table-header-color="green" v-model="paginedSorties">
              <md-table-row slot="md-table-row" slot-scope="{ item }">
                <md-table-cell
                  md-label="الإسم الكامل"
                >{{ item.personne.prenom }} {{ item.personne.nom }}</md-table-cell>
                <md-table-cell md-label="التاريخ">{{item.date}}</md-table-cell>
                <md-table-cell md-label="الثمن الإجمالي">{{item.montant_total}}</md-table-cell>
                <md-table-cell md-label="المبلغ المدفوع">{{ item.montant}}</md-table-cell>
                <md-table-cell md-label="المبلغ المتبقي">{{item.montant_total - item.montant}}</md-table-cell>
                <md-table-cell md-label="إختيار">
                  <md-button class="md-success md-just-icon md-round" @click="avances(item)">
                    <md-icon  class="fa fa-dollar-sign"></md-icon>
                  </md-button>
                  <md-button
                    data-toggle="modal"
                    data-target="#exampleModal2"
                    @click="toModalDollar(item)"
                    class="md-danger md-just-icon md-round"
                  >
                    <md-icon>add</md-icon>
                  </md-button>
                  <md-button class="md-warning md-just-icon md-round" @click="lignes(item)">
                    <md-icon>menu</md-icon>
                  </md-button>
                  <md-button class="md-info md-just-icon md-round" @click="toModalPrint(item)">
                    <md-icon>
                      <i class="fa fa-file-pdf-o"></i>
                    </md-icon>
                  </md-button>
                  <md-button class="md-default md-just-icon md-round" @click="goToEdit(item)">
                    <md-icon>edit</md-icon>
                  </md-button>
                </md-table-cell>
              </md-table-row>
            </md-table>
          </md-card-content>
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
      </div>
      <!--impression-->
      <mdb-modal :show="modal" @close="modal = false">
        <mdb-modal-header>
          <mdb-modal-title></mdb-modal-title>
        </mdb-modal-header>
        <mdb-modal-body>
          <input
            class="form-control form-control-lg"
            v-model="bon.entreprise"
            type="text"
            placeholder="اسم الشركة"
          />
        </mdb-modal-body>
        <mdb-modal-body>
          <input
            class="form-control form-control-lg"
            v-model="bon.tel"
            type="text"
            placeholder="رقم الهاتف"
          />
        </mdb-modal-body>
        <mdb-modal-body>
          <input
            class="form-control form-control-lg"
            v-model="bon.face"
            type="text"
            placeholder="فايسبوك"
          />
        </mdb-modal-body>
        <mdb-modal-body>
          <input
            class="form-control form-control-lg"
            type="text"
            v-model="bon.site"
            placeholder="الموقع الإلكتروني"
          />
        </mdb-modal-body>
        <mdb-modal-footer>
          <mdb-btn @click="print()" color="primary">التالي</mdb-btn>
          <mdb-btn color="secondary" style="margin :10px;" @click.native="modal = false">إغلاق</mdb-btn>
        </mdb-modal-footer>
      </mdb-modal>
    </div>

    <!-- paiement -->
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
            <h5 class="modal-title" id="exampleModalLabel">المرجو إدخال المعلومات التالية</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <select class="custom-select" v-model="AvanceSortie.type_paiement">
              <option value="1">كيفية الدفع</option>
              <option value="شيك">شيك</option>
              <option value="كمبيالة">كمبيالة</option>
              <option value="مبادلة">مبادلة</option>
              <option value="نقد">نقد</option>
              <option value="رميز">رميز</option>
            </select>
            <p></p>
             <input
              type="text"
              placeholder="رقم الشيك أو الكمبيالة"
              v-model="AvanceSortie.numero"
              class="form-control mb-4"
            />
            <p></p>
            <input
              type="number"
              placeholder="المبلغ"
              v-model="AvanceSortie.montant"
              class="form-control mb-4"
            />
            <input type="date" v-model="AvanceSortie.date" class="form-control mb-4" />
            <textarea
              v-model="AvanceSortie.description"
              rows="5"
              cols="33"
              class="form-control mb-4"
              placeholder="ملاحضات"
            />
          </div>

          <div class="modal-footer">
            <button
              type="button"
              data-dismiss="modal"
              class="btn btn-success"
              @click="addAvanceSortie()"
              style="margin-top : -15px;border-color: #4caf50;background-color: #4caf50 !important;font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
            >حفظ</button>
            <button
              type="button"
              class="btn btn-secondary"
              style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
              data-dismiss="modal"
            >خروج</button>
          </div>
        </div>
      </div>
    </div>
    <!--lignes d'entree-->
    <mdb-modal :show="modalLignes" @close="modalLignes = false">
      <mdb-modal-header>
        <mdb-modal-title></mdb-modal-title>
      </mdb-modal-header>
      <mdb-modal-body>
        <md-table table-header-color="green" v-model="lignesSortie">
          <md-table-row slot="md-table-row" slot-scope="{ item }">
            <md-table-cell
              md-label="نوع البضاعة"
              :id="'ref' + item.id"
              contenteditable="true"
            >{{item.serie.ref}}</md-table-cell>
            <md-table-cell
              md-label="اللون"
              :id="'couleur' + item.id"
              contenteditable="true"
            >{{item.serie.couleur}}</md-table-cell>
            <md-table-cell
              :id="'prix' + item.id"
              contenteditable="true"
              md-label="ثمن البيع"
            >{{item.prix_unitaire}}</md-table-cell>
            <md-table-cell
              :id="'qte' + item.id"
              contenteditable="true"
              md-label="العدد"
            >{{ item.qte}}</md-table-cell>
            <md-table-cell md-label="اختيار">
              <md-button @click="saveLigneSortie(item)" class="md-warning md-just-icon md-round">
                <md-icon>edit</md-icon>
              </md-button>
            </md-table-cell>
          </md-table-row>
        </md-table>
      </mdb-modal-body>
      <mdb-modal-footer>
        <mdb-btn color="secondary" style="margin :10px;" @click.native="modalLignes = false">إغلاق</mdb-btn>
      </mdb-modal-footer>
    </mdb-modal>
    <!--avances d'entree-->
    <mdb-modal :show="modalAvances" @close="modalAvances = false">
      <mdb-modal-header>
        <mdb-modal-title></mdb-modal-title>
      </mdb-modal-header>
      <mdb-modal-body>
        <md-table table-header-color="green" v-model="avancesSortie">
          <md-table-row slot="md-table-row" slot-scope="{ item }">
            <md-table-cell md-label="كيفية الدفع">{{item.type_paiement}}</md-table-cell>
            <md-table-cell md-label="الرقم">{{item.numero}}</md-table-cell>
            <md-table-cell md-label="التاريخ">{{item.date}}</md-table-cell>
            <md-table-cell md-label="المبلغ">{{item.montant}}</md-table-cell>
            <md-table-cell md-label="الوصف">{{ item.description}}</md-table-cell>
             <md-button
                @click="goToEditAvance(item)"
                data-toggle="modal"
                data-target="#exampleModal3"
                class="md-warning md-just-icon md-round"
              >
                <md-icon>edit</md-icon>
              </md-button>
          </md-table-row>
        </md-table>
      </mdb-modal-body>
      <mdb-modal-footer>
        <mdb-btn color="secondary" style="margin :10px;" @click.native="modalAvances = false">إغلاق</mdb-btn>
      </mdb-modal-footer>
    </mdb-modal>
    <!-- modification -->
    <mdb-modal :show="modalModif" @close="modalModif = false">
      <mdb-modal-header>
        <mdb-modal-title></mdb-modal-title>
      </mdb-modal-header>
      <mdb-modal-body>
        <select class="custom-select" v-model="selectedF">
          <option
            v-for="client in clients"
            :key="client.id"
            :value="client.id"
          >{{client.personne.nom}} {{client.personne.prenom}}</option>
        </select>
        <p></p>
        <input type="date" v-model="dateM" class="form-control mb-4" />
      </mdb-modal-body>
      <mdb-modal-footer>
        <mdb-btn color="primary" style="margin :10px;" @click="modifier()">حفظ</mdb-btn>
        <mdb-btn color="secondary" style="margin :10px;" @click.native="modalModif = false">إغلاق</mdb-btn>
      </mdb-modal-footer>
    </mdb-modal>
     <!-- modifier avance -->

    <div
      class="modal fade"
      id="exampleModal3"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <select class="custom-select" v-model="AvanceSortie.type_paiement">
              <option value="1">كيفية الدفع</option>
              <option value="شيك">شيك</option>
              <option value="كمبيالة">كمبيالة</option>
              <option value="مبادلة">مبادلة</option>
              <option value="نقد">نقد</option>
              <option value="رميز">رميز</option>
            </select>
            <p></p>
            <input
              type="text"
              placeholder="رقم الشيك أو الكمبيالة"
              v-model="AvanceSortie.numero"
              class="form-control mb-4"
            />
            <p></p>
            <input
              type="number"
              placeholder="المبلغ"
              v-model="AvanceSortie.montant"
              class="form-control mb-4"
            />
            <input type="date" v-model="AvanceSortie.date" class="form-control mb-4" />
            <textarea
              v-model="AvanceSortie.description"
              rows="5"
              cols="33"
              class="form-control mb-4"
              placeholder="ملاحضات"
            />
          </div>

          <div class="modal-footer">
            <button
              type="button"
              data-dismiss="modal"
              class="btn btn-success"
              @click="modifierAvanceSortie()"
              style="margin-top : -15px;border-color: #4caf50;background-color: #4caf50 !important;font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
            >حفظ</button>
            <button
              type="button"
              class="btn btn-secondary"
              style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
              data-dismiss="modal"
            >خروج</button>
          </div>
        </div>
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
            <h5 class="modal-title" id="exampleModalLabel">المرجو إدخال المعلومات التالية</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <select class="custom-select" v-model="client">
              <option value="1">الزبون</option>
              <option
                v-for="client in clients"
                :key="client.id"
                :value="client"
              >{{client.personne.nom}} {{client.personne.prenom}}</option>
            </select>
            <p></p>
            <input type="date" v-model="Sortie.date" class="form-control mb-4" />
          </div>

          <div class="modal-footer">
            <button
              type="button"
              data-dismiss="modal"
              class="btn btn-success"
              @click="goToAdd()"
              style="margin-top : -15px;border-color: #4caf50;background-color: #4caf50 !important;font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
            >التالي</button>
            <button
              type="button"
              class="btn btn-secondary"
              style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
              data-dismiss="modal"
            >خروج</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
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
  data() {
    return {
      clients: null,
      sorties: [],
      modal: false,
      modalLignes: false,
      lignesSortie: [],
      modalAvances: false,
      avancesSortie: [],
      selected: "1",
      client: new Object(),
      Sortie: {
        id: "",
        id_client: "",
        date: this.formatDate(new Date())
      },
      AvanceSortie: {
        type_paiement: "1",
        sortie_id: "",
        date: this.formatDate(new Date()),
        description: "",
        montant: ""
      },
      bon: {
        entreprise: "",
        tel: "",
        face: "",
        site: "",
        sorties: new Object()
      },
      sortie: new Object(),
      dates: [],
      montants_totaux: [],
      montants: [],
      noms_marques: [],
      nom: "",
      prenom: "",
      date: "",
      montant_total: "",
      montant: "",
      nom_marque: "",
      token: localStorage.getItem("token"),
      modalModif: false,
      selectedF: new Object(),
      dateM: null,
      page: 0,
      itemsPerPage: 2
    };
  },
  created() {
    this.fetchClients();
    this.fetchSorties();
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
    goToEdit(sortie) {
      this.dateM = sortie.date;
      this.selectedF = sortie.client.id;
      this.Sortie = sortie;
      this.modalModif = true;
    },
    modifier() {
      this.Sortie.date = this.dateM;
      this.Sortie.client.id = this.selectedF;
      fetch("api/modifierSortie", {
        method: "put",
        body: JSON.stringify(this.Sortie),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          this.fetchSorties();
          this.modalModif = false;
        })
        .catch(err => console.log(err));
    },
     saveLigneSortie(ligneSortie) {
      var prix = document.getElementById("prix" + ligneSortie.id);
      var qte = document.getElementById("qte" + ligneSortie.id);
      var couleur = document.getElementById("couleur" + ligneSortie.id);
      var ref = document.getElementById("ref" + ligneSortie.id);
      ligneSortie.prix_unitaire = prix.innerHTML
        .toString()
        .split(">")[1]
        .split("<")[0];
      ligneSortie.qte = qte.innerHTML
        .toString()
        .split(">")[1]
        .split("<")[0];
      ligneSortie.serie.couleur = couleur.innerHTML
        .toString()
        .split(">")[1]
        .split("<")[0];
      ligneSortie.serie.ref = ref.innerHTML
        .toString()
        .split(">")[1]
        .split("<")[0];

      fetch(`api/ligneSortie/${ligneSortie.id}`, {
        method: "put",
        body: JSON.stringify(ligneSortie),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(res => {
          this.fetchSorties();
        })
        .catch(err => console.log(err));
    },
     goToEditAvance(avance) {
      this.AvanceSortie.type_paiement = avance.type_paiement;
      this.AvanceSortie.id = avance.id;
      this.AvanceSortie.date = avance.date;
      this.AvanceSortie.numero = avance.numero;
      this.AvanceSortie.montant = avance.montant;
      this.AvanceSortie.description = avance.description;
      this.modalAvances = false;
    },
     modifierAvanceSortie() {
       fetch("api/modifierAvanceSortie", {
        method: "put",
        body: JSON.stringify(this.AvanceSortie),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          this.fetchSorties();
        })
        .catch(err => console.log(err));
    },
    lignes(sortie) {
      this.lignesSortie = sortie.lignes;
      this.modalLignes = true;
    },
    avances(sortie) {
      this.AvanceSortie.sortie_id = sortie.id;
      this.avancesSortie = sortie.avances;
      this.modalAvances = true;
    },
    toModalPrint(sortie) {
      this.modal = true;
      this.bon.sorties = sortie;
    },
    print() {
      fetch("api/printSortie", {
        method: "post",
        body: JSON.stringify(this.bon),
        headers: {
          "content-type": "application/json"
        }
      }).catch(err => console.log(err));
    },
    toModalDollar(sortie) {
      this.sortie = sortie;
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
    fetchClients() {
      fetch("/api/clients?token=" + this.token)
        .then(res => res.json())
        .then(res => {
          this.clients = res.data;
        })
        .catch(err => console.log(err));
    },
    fetchSorties() {
      fetch("/api/sorties?token=" + this.token)
        .then(res => res.json())
        .then(res => {
          this.sorties = res.data;
        })
        .catch(err => console.log(err));
    },

    addAvanceSortie() {
      this.AvanceSortie.sortie_id = this.sortie.id;
      fetch("api/AvanceSortie?token=" + this.token, {
        method: "post",
        body: JSON.stringify(this.AvanceSortie),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          let object = {
            AvanceSortie: data.data,
            Sortie: this.sortie
          };
          //this.$router.push({ name: "ajouterEntree", params: { object } });
        })

        .catch(err => console.log(err));
      if (
        this.AvanceSortie.type_paiement == "نقد" ||
        this.AvanceSortie.type_paiement == "مبادلة" ||
        this.AvanceSortie.type_paiement == "رميز"
      ) {
        var n1 = this.sortie.montant;
        var n2 = this.AvanceSortie.montant;
        this.sortie.montant = n1 + Number(n2);
        fetch(`api/sortie/${this.sortie.id}`, {
          method: "put",
          body: JSON.stringify(this.sortie),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(res => {
            this.fetchSorties();
          })
          .catch(err => console.log(err));
      }
      //AvanceEntree
    },
    /*update(){
      fetch(`api/entree/${this.entree.id}`, {
          method: "put",
          body: JSON.stringify(this.entree),
          headers: {
            "content-type": "application/json"
          }
        })
         .then(res => res.json())
          .then(res => {
            this.fetchEntrees();
          })
          .catch(err => console.log(err));
    },*/
    goToAdd() {
      //ajouter Entree
      this.Sortie.id_client = this.client.id;
      fetch("api/sortie?token=" + this.token, {
        method: "post",
        body: JSON.stringify(this.Sortie),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          let object = {
            Sortie: data.data,
            Client: this.client
          };
          this.$router.push({ name: "ajouterSortie", params: { object } });
        })
        .catch(err => console.log(err));
      ///////////////////////////////////
    }
  },
  computed: {
    filtred: function() {
      let currentObject = this;
      return this.sorties.filter(function(item) {
        return (
          item.personne.nom.includes(currentObject.nom) &&
          item.personne.prenom.includes(currentObject.prenom) &&
          item.date.includes(currentObject.date.toString()) &&
          item.montant_total
            .toString()
            .includes(currentObject.montant_total.toString()) &&
          item.montant.toString().includes(currentObject.montant.toString())
        );
      });
    },
    paginedSorties() {
      return this.filtred.slice(
        this.page * this.itemsPerPage,
        this.itemsPerPage * this.page + this.itemsPerPage
      );
    }
  }
};
</script>
  