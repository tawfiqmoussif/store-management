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
            <h4 class="title">قائمة الواردات</h4>
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
            <md-table table-header-color="green" v-model="paginedEntrees">
              <md-table-row slot="md-table-row" slot-scope="{ item }">
                <md-table-cell
                  md-label="الإسم الكامل"
                >{{ item.personne.prenom }} {{ item.personne.nom }}</md-table-cell>
                <md-table-cell editable md-label="التاريخ">{{item.date}}</md-table-cell>
                <md-table-cell md-label="الثمن الإجمالي">{{item.montant_total}}</md-table-cell>
                <md-table-cell md-label="المبلغ المدفوع للمورد">{{ item.montant_paye}}</md-table-cell>
                <md-table-cell md-label="المبلغ المتبقي">{{item.montant_total - item.montant_paye}}</md-table-cell>
                <md-table-cell md-label="إسم العلامة التجارية">{{ item.fournisseur.nom_marque }}</md-table-cell>
                <md-table-cell md-label="إختيار">
                  <md-button class="md-success md-just-icon md-round" @click="lignes(item)">
                    <md-icon>menu</md-icon>
                  </md-button>
                  <md-button
                    data-toggle="modal"
                    data-target="#exampleModal2"
                    @click="toModalDollar(item)"
                    class="md-danger md-just-icon md-round"
                  >
                    <md-icon>add</md-icon>
                  </md-button>
                  <md-button class="md-info md-just-icon md-round" @click="toModalPrint(item)">
                    <md-icon>
                      <i class="fa fa-file-pdf-o"></i>
                    </md-icon>
                  </md-button>
                  <md-button class="md-warning md-just-icon md-round" @click="avances(item)">
                    <md-icon class="fa fa-dollar-sign"></md-icon>
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
    <!--lignes d'entree-->
    <mdb-modal :show="modalLignes" @close="modalLignes = false">
      <mdb-modal-header>
        <mdb-modal-title></mdb-modal-title>
      </mdb-modal-header>
      <mdb-modal-body>
        <md-table table-header-color="green" v-model="lignesEntree">
          <md-table-row slot="md-table-row" slot-scope="{ item }">
            <md-table-cell
              :id="'ref' + item.id"
              contenteditable="true"
              md-label="نوع البضاعة"
            >{{item.serie.ref}}</md-table-cell>
            <md-table-cell
              :id="'couleur' + item.id"
              contenteditable="true"
              md-label="اللون"
            >{{item.serie.couleur}}</md-table-cell>
            <md-table-cell
              :id="'prix' + item.id"
              contenteditable="true"
              md-label="ثمن الشراء"
            >{{ item.prix_unitaire}}</md-table-cell>
            <md-table-cell
              :id="'prix_de_vente' + item.id"
              contenteditable="true"
              md-label="ثمن البيع"
            >{{item.prix_de_vente}}</md-table-cell>
            <md-table-cell
              :id="'qte' + item.id"
              contenteditable="true"
              md-label="العدد"
            >{{ item.qte}}</md-table-cell>
            <md-table-cell md-label="اختيار">
              <md-button @click="saveLigneEntree(item)" class="md-warning md-just-icon md-round">
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
        <md-table table-header-color="green" v-model="avancesEntree">
          <md-table-row slot="md-table-row" slot-scope="{ item }">
            <md-table-cell md-label="كيفية الدفع">{{item.type_paiement}}</md-table-cell>
            <md-table-cell md-label="الرقم">{{item.numero}}</md-table-cell>
            <md-table-cell md-label="التاريخ">{{item.date}}</md-table-cell>
            <md-table-cell md-label="المبلغ">{{item.montant}}</md-table-cell>
            <md-table-cell md-label="الوصف">{{ item.description}}</md-table-cell>
            <md-table-cell md-label="اختيار">
              <md-button
                @click="goToEditAvance(item)"
                data-toggle="modal"
                data-target="#exampleModal3"
                class="md-warning md-just-icon md-round"
              >
                <md-icon>edit</md-icon>
              </md-button>
            </md-table-cell>
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
          <option value="0">المورد</option>
          <option
            v-for="fournisseur in fournisseurs"
            :key="fournisseur.id"
            :value="fournisseur.id"
          >{{fournisseur.personne.nom}} {{fournisseur.personne.prenom}}</option>
        </select>
        <p></p>
        <input type="date" v-model="dateM" class="form-control mb-4" />
      </mdb-modal-body>
      <mdb-modal-footer>
        <mdb-btn color="primary" style="margin :10px;" @click="modifier()">حفظ</mdb-btn>
        <mdb-btn color="secondary" style="margin :10px;" @click.native="modalModif = false">إغلاق</mdb-btn>
      </mdb-modal-footer>
    </mdb-modal>

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
            <select class="custom-select" v-model="AvanceEntree.type_paiement">
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
              v-model="AvanceEntree.numero"
              class="form-control mb-4"
            />
            <p></p>
            <input
              type="number"
              placeholder="المبلغ"
              v-model="AvanceEntree.montant"
              class="form-control mb-4"
            />
            <input type="date" v-model="AvanceEntree.date" class="form-control mb-4" />
            <textarea
              v-model="AvanceEntree.description"
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
              @click="addAvanceEntree()"
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
            <select class="custom-select" v-model="AvanceEntree.type_paiement">
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
              v-model="AvanceEntree.numero"
              class="form-control mb-4"
            />
            <p></p>
            <input
              type="number"
              placeholder="المبلغ"
              v-model="AvanceEntree.montant"
              class="form-control mb-4"
            />
            <input type="date" v-model="AvanceEntree.date" class="form-control mb-4" />
            <textarea
              v-model="AvanceEntree.description"
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
              @click="modifierAvanceEntree()"
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
    <!---->
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
            <select class="custom-select" v-model="fournisseur">
              <option value="1">المورد</option>
              <option
                v-for="fournisseur in fournisseurs"
                :key="fournisseur.id"
                :value="fournisseur"
              >{{fournisseur.personne.nom}} {{fournisseur.personne.prenom}}</option>
            </select>
            <p></p>
            <input type="date" v-model="Entree.date" class="form-control mb-4" />
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
      fournisseurs: null,
      entrees: [],
      modal: false,
      modalLignes: false,
      lignesEntree: [],
      modalAvances: false,
      avancesEntree: [],
      selected: "1",
      fournisseur: new Object(),
      Entree: {
        id: "",
        id_fournisseur: "",
        date: this.formatDate(new Date())
      },
      AvanceEntree: {
        type_paiement: "1",
        entree_id: "",
        date: this.formatDate(new Date()),
        description: "",
        montant: ""
      },
      bon: {
        entreprise: "",
        tel: "",
        face: "",
        site: "",
        entrees: new Object()
      },
      entree: new Object(),
      //noms: [],
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
    this.fetchFournisseurs();
    this.fetchEntrees();
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
    lignes(entree) {
      this.lignesEntree = entree.lignes;
      this.modalLignes = true;
    },
    avances(entree) {
      this.AvanceEntree.entree_id = entree.id;
      this.avancesEntree = entree.avances;
      this.modalAvances = true;
    },
    toModalPrint(entree) {
      this.modal = true;
      this.bon.entrees = entree;
    },
    print() {
      fetch("api/print", {
        method: "post",
        body: JSON.stringify(this.bon),
        headers: {
          "content-type": "application/json"
        }
      }).catch(err => console.log(err));
    },
    toModalDollar(entree) {
      //entree.montant=AvanceEntree.montant;
      this.entree = entree;
    },
    modifierAvanceEntree() {
       fetch("api/modifierAvanceEntree", {
        method: "put",
        body: JSON.stringify(this.AvanceEntree),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          this.fetchEntrees();
        })
        .catch(err => console.log(err));
    },
    saveLigneEntree(ligneEntree) {
      var prix = document.getElementById("prix" + ligneEntree.id);
      var qte = document.getElementById("qte" + ligneEntree.id);
      var couleur = document.getElementById("couleur" + ligneEntree.id);
      var ref = document.getElementById("ref" + ligneEntree.id);
      var prix_de_vente = document.getElementById(
        "prix_de_vente" + ligneEntree.id
      );
      ligneEntree.prix_unitaire = prix.innerHTML
        .toString()
        .split(">")[1]
        .split("<")[0];
      ligneEntree.qte = qte.innerHTML
        .toString()
        .split(">")[1]
        .split("<")[0];
      ligneEntree.prix_de_vente = prix_de_vente.innerHTML
        .toString()
        .split(">")[1]
        .split("<")[0];
      ligneEntree.serie.couleur = couleur.innerHTML
        .toString()
        .split(">")[1]
        .split("<")[0];
      ligneEntree.serie.ref = ref.innerHTML
        .toString()
        .split(">")[1]
        .split("<")[0];

      fetch(`api/ligneEntree/${ligneEntree.id}`, {
        method: "put",
        body: JSON.stringify(ligneEntree),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(res => {
          this.fetchEntrees();
        })
        .catch(err => console.log(err));
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
      fetch("/api/fournisseurs?token=" + this.token)
        .then(res => res.json())
        .then(res => {
          this.fournisseurs = res.data;
        })
        .catch(err => console.log(err));
    },
    goToEdit(entree) {
      this.dateM = entree.date;
      this.selectedF = entree.fournisseur.id;
      this.Entree = entree;
      this.modalModif = true;
    },
    modifier() {
      this.Entree.date = this.dateM;
      this.Entree.fournisseur.id = this.selectedF;
      fetch("api/modifierEntree", {
        method: "put",
        body: JSON.stringify(this.Entree),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          this.fetchEntrees();
          this.modalModif = false;
        })
        .catch(err => console.log(err));
    },
    fetchEntrees() {
      fetch("/api/entrees?token=" + this.token)
        .then(res => res.json())
        .then(res => {
          this.entrees = res.data;
        })
        .catch(err => console.log(err));
    },
    goToEditAvance(avance) {
      this.AvanceEntree.type_paiement = avance.type_paiement;
      this.AvanceEntree.id = avance.id;
      this.AvanceEntree.date = avance.date;
      this.AvanceEntree.numero = avance.numero;
      this.AvanceEntree.montant = avance.montant;
      this.AvanceEntree.description = avance.description;
      this.modalAvances = false;
    },
    addAvanceEntree() {
      this.AvanceEntree.entree_id = this.entree.id;

      fetch("api/AvanceEntree?token=" + this.token, {
        method: "post",
        body: JSON.stringify(this.AvanceEntree),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          this.fetchEntrees();
          let object = {
            AvanceEntree: data.data,
            Entree: this.entree
          };
        })

        .catch(err => console.log(err));
      if (
        this.AvanceEntree.type_paiement == "نقد" ||
        this.AvanceEntree.type_paiement == "مبادلة" ||
        this.AvanceEntree.type_paiement == "رميز"
      ) {
        var n1 = this.entree.montant_paye;
        var n2 = this.AvanceEntree.montant;
        this.entree.montant_paye = n1 + Number(n2);
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
      }
    },
    goToAdd() {
      //ajouter Entree
      this.Entree.id_fournisseur = this.fournisseur.id;
      fetch("api/entree?token=" + this.token, {
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
      ///////////////////////////////////
    }
  },
  computed: {
    filtred: function() {
      let currentObject = this;
      return this.entrees.filter(function(item) {
        return (
          item.personne.nom.includes(currentObject.nom) &&
          item.personne.prenom.includes(currentObject.prenom) &&
          item.date.includes(currentObject.date.toString()) &&
          item.montant_total
            .toString()
            .includes(currentObject.montant_total.toString()) &&
          item.fournisseur.nom_marque.includes(currentObject.nom_marque) &&
          item.montant_paye
            .toString()
            .includes(currentObject.montant.toString())
        );
      });
    },
    paginedEntrees() {
      return this.filtred.slice(
        this.page * this.itemsPerPage,
        this.itemsPerPage * this.page + this.itemsPerPage
      );
    }
  }
};
</script>
  