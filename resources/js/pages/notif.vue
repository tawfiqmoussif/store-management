<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item">
        <md-card>
          <md-card-header data-background-color="green">
            <h4 class="title">الإشعارات</h4>
            <p class="category"></p>
          </md-card-header>
          <md-card-content>
            <div class="md-layout">
              <div class="md-layout-item md-medium-size-100">
                <h5>الواردات</h5>
                <div class="alert alert-danger" :key="avance.id" v-for="avance in avancesEntree">
                  <button type="button" aria-hidden="true" class="close" @click="noEntree(avance)">
                    <i class="fas fa-times"></i>
                  </button>

                  <button
                    style="margin-left: 5px;"
                    type="button"
                    @click="okEntree(avance)"
                    aria-hidden="true"
                    class="close"
                  >
                    <i class="fas fa-check"></i>
                  </button>
                  <span>يجب عليك إداع مبلغ {{avance.montant}} درهم اليوم في حساب {{avance.entree.personne.nom}} {{avance.entree.personne.prenom}} ({{avance.type_paiement}})</span>
                  <span>الوصف: {{avance.description}}</span>
                  <a></a>
                </div>
              </div>
              <div class="md-layout-item md-medium-size-100">
                <h5>المبيعات</h5>

                <div class="alert alert-info" :key="avance.id" v-for="avance in avancesSortie">
                  <button type="button" aria-hidden="true" class="close" @click="noSortie(avance)">
                    <i class="fas fa-times"></i>
                  </button>
                  <button
                    style="margin-left: 5px;"
                    type="button"
                    @click="okSortie(avance)"
                    aria-hidden="true"
                    class="close"
                  >
                    <i class="fas fa-check"></i>
                  </button>
                  <span>يجب عليك إستلام مبلغ {{avance.montant}} درهم اليوم من حساب السيد {{avance.sortie.personne.nom}} {{avance.sortie.personne.prenom}} ({{avance.type_paiement}})</span>
                  <span> الوصف: {{avance.description }}</span>
                </div>
              </div>
            </div>
          </md-card-content>
        </md-card>
        <!--les commandes en attente-->
        <md-card>
          <md-card-content>
            <div class="md-layout">
              <div class="md-layout-item md-medium-size-200">
                <h5>طلبات أصحاب المحلات</h5>
                <md-table v-model="commandes_en_attente" table-header-color="green">
                  <md-table-row
                    slot="md-table-row"
                    slot-scope="{ item }"
                    style="direction: ltr !important;"
                  >
                    <md-table-cell
                      md-label="صاحب الطلب"
                    >{{item.clientO.personne.nom}} {{item.clientO.personne.prenom}}</md-table-cell>
                    <md-table-cell md-label="نوع البضاعة">{{item.serie.ref}}</md-table-cell>
                    <md-table-cell md-label="اللون">{{item.serie.couleur}}</md-table-cell>
                    <md-table-cell
                      md-label="المورد"
                    >{{item.serie.personne.nom}} {{item.serie.personne.prenom}}</md-table-cell>
                    <md-table-cell md-label="التاريخ">{{item.date}}</md-table-cell>
                    <md-table-cell md-label="اختيار">
                      <md-button @click="refuse(item)" class="md-danger md-just-icon md-round">
                        <i class="fas fa-times"></i>
                      </md-button>
                      <md-button
                        @click="lanceModalPrixCommande(item)"
                        class="md-success md-just-icon md-round"
                      >
                        <i class="fas fa-check"></i>
                      </md-button>
                      <md-button
                        @click="articlesCommande(item)"
                        class="md-warning md-just-icon md-round"
                      >
                        <md-icon>menu</md-icon>
                      </md-button>
                    </md-table-cell>
                  </md-table-row>
                </md-table>
              </div>
            </div>
          </md-card-content>
        </md-card>
        <!---->
        <!--les commandes acceptees-->
        <md-card>
          <md-card-content>
            <div class="md-layout">
              <div class="md-layout-item md-medium-size-200">
                <h5>طلباتي المقبولة</h5>
                <md-table v-model="commandes_acceptees" table-header-color="green">
                  <md-table-row
                    slot="md-table-row"
                    slot-scope="{ item }"
                    style="direction: ltr !important;"
                  >
                    <md-table-cell
                      md-label="صاحب المحل"
                    >{{item.fournisseurO.personne.nom}} {{item.fournisseurO.personne.prenom}}</md-table-cell>
                    <md-table-cell md-label="نوع البضاعة">{{item.serie.ref}}</md-table-cell>
                    <md-table-cell md-label="اللون">{{item.serie.couleur}}</md-table-cell>
                    <md-table-cell
                      md-label="المورد"
                    >{{item.serie.personne.nom}} {{item.serie.personne.prenom}}</md-table-cell>
                    <md-table-cell md-label="التاريخ">{{item.date}}</md-table-cell>
                    <md-table-cell md-label="اختيار">
                       <md-button @click="non_recu(item)" class="md-danger md-just-icon md-round">
                        <i class="fas fa-times"></i>
                      </md-button>
                      <md-button @click="recu(item)" class="md-success md-just-icon md-round">
                        <i class="fas fa-check"></i>
                      </md-button>
                      <md-button
                        @click="articlesCommandeRecu(item)"
                        class="md-warning md-just-icon md-round"
                      >
                        <md-icon>menu</md-icon>
                      </md-button>
                     
                    </md-table-cell>
                  </md-table-row>
                </md-table>
              </div>
            </div>
          </md-card-content>
        </md-card>
        <!-- modale des articles -->
        <mdb-modal :show="modalArticles" @close="modalArticles = false">
          <mdb-modal-header>
            <mdb-modal-title></mdb-modal-title>
          </mdb-modal-header>
          <mdb-modal-body>
            <md-table table-header-color="green" v-model="ArticlesCommande">
              <md-table-row slot="md-table-row" slot-scope="{ item }">
                <md-table-cell md-label="رقم الحذاء">{{item.taille}}</md-table-cell>
                <md-table-cell md-label="الكمية المطلوبة">{{item.qte}}</md-table-cell>
              </md-table-row>
            </md-table>
          </mdb-modal-body>
          <mdb-modal-footer>
            <mdb-btn
              color="secondary"
              style="margin :10px;"
              @click.native="modalArticles = false"
            >إغلاق</mdb-btn>
          </mdb-modal-footer>
        </mdb-modal>
        <!---->
        <!-- modale des articles -->
        <mdb-modal :show="modalArticlesRecu" @close="modalArticlesRecu = false">
          <mdb-modal-header>
            <mdb-modal-title></mdb-modal-title>
          </mdb-modal-header>
          <mdb-modal-body>
            <md-table table-header-color="green" v-model="ArticlesCommande">
              <md-table-row slot="md-table-row" slot-scope="{ item }">
                <md-table-cell md-label="رقم الحذاء">{{item.taille}}</md-table-cell>
                <md-table-cell
                  :id="'qte' + item.id"
                  contenteditable="true"
                  md-label="الكمية التي توصلت بها"
                >{{item.qte}}</md-table-cell>
                <md-table-cell md-label="اختيار">
                  <md-button
                    @click="saveArticleCommande(item)"
                    class="md-warning md-just-icon md-round"
                  >
                    <md-icon>edit</md-icon>
                  </md-button>
                </md-table-cell>
              </md-table-row>
            </md-table>
          </mdb-modal-body>
          <mdb-modal-footer>
            <mdb-btn
              color="secondary"
              style="margin :10px;"
              @click.native="modalArticlesRecu = false"
            >إغلاق</mdb-btn>
          </mdb-modal-footer>
        </mdb-modal>
        <!---->
        <mdb-modal :show="modal" @close="modal = false">
          <mdb-modal-header>
            <mdb-modal-title>أدخل التاريخ الجديد</mdb-modal-title>
          </mdb-modal-header>
          <mdb-modal-body>
            <input type="date" v-model="avanceE.date" class="form-control mb-4" />
          </mdb-modal-body>
          <mdb-modal-footer>
            <mdb-btn color="primary" style="margin :10px;" @click="saveE">حفظ</mdb-btn>
            <mdb-btn color="secondary" style="margin :10px;" @click.native="modal = false">إغلاق</mdb-btn>
          </mdb-modal-footer>
        </mdb-modal>
        <mdb-modal :show="modalS" @close="modalS = false">
          <mdb-modal-header>
            <mdb-modal-title>أدخل التاريخ الجديد</mdb-modal-title>
          </mdb-modal-header>
          <mdb-modal-body>
            <input type="date" v-model="avanceS.date" class="form-control mb-4" />
          </mdb-modal-body>
          <mdb-modal-footer>
            <mdb-btn color="primary" style="margin :10px;" @click="saveS">حفظ</mdb-btn>
            <mdb-btn color="secondary" style="margin :10px;" @click.native="modalS = false">إغلاق</mdb-btn>
          </mdb-modal-footer>
        </mdb-modal>
        <!--prix-->
        <mdb-modal :show="prixModal" @close="prixModal = false">
          <mdb-modal-header>
            <mdb-modal-title>أدخل المعلومات التالية</mdb-modal-title>
          </mdb-modal-header>
          <mdb-modal-body>
            <div class="md-layout-item md-small-size-100 md-size-100">
              <md-field>
                <label
                  style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                >ثمن شراء صاحب المحل</label>
                <md-input type="text" v-model="prix_unitaire"></md-input>
              </md-field>
            </div>
            <div class="md-layout-item md-small-size-100 md-size-100">
              <md-field>
                <label
                  style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                >ثمن بيع صاحب المحل</label>
                <md-input type="text" v-model="prix_de_vente"></md-input>
              </md-field>
            </div>
            <div class="md-layout-item md-small-size-100 md-size-100">
              <md-field>
                <label
                  style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                >ثمن الشراء المحدد من طرف صاحب المحل</label>
                <md-input type="text" v-model="commandeT.prix"></md-input>
              </md-field>
            </div>
            <div class="md-layout-item md-small-size-100 md-size-100">
              <md-field>
                <label
                  style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;"
                >ثمن البيع</label>
                <md-input type="text" v-model="prix_de_vente_2"></md-input>
              </md-field>
            </div>
          </mdb-modal-body>
          <mdb-modal-footer>
            <mdb-btn color="primary" style="margin :10px;" @click="recuTraitement(commandeT)">حفظ</mdb-btn>
            <mdb-btn color="secondary" style="margin :10px;" @click.native="prixModal = false">إغلاق</mdb-btn>
          </mdb-modal-footer>
        </mdb-modal>
        <!-- ------------------------->
        <!--prixCommande-->
        <mdb-modal :show="modalPrixCommande" @close="modalPrixCommande = false">
          <mdb-modal-header>
            <mdb-modal-title>المرجو إدخال ثمن البيع</mdb-modal-title>
          </mdb-modal-header>
          <mdb-modal-body>
            <input
              type="text"
              v-model="commandeAcceptee.prix"
              placeholder="ثمن البيع"
              class="form-control mb-4"
            />
          </mdb-modal-body>
          <mdb-modal-footer>
            <mdb-btn color="primary" style="margin :10px;" @click="accepte()">حفظ</mdb-btn>
            <mdb-btn
              color="secondary"
              style="margin :10px;"
              @click.native="modalPrixCommande = false"
            >إغلاق</mdb-btn>
          </mdb-modal-footer>
        </mdb-modal>
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
      type: ["", "info", "success", "warning", "danger"],
      avancesEntree: new Object(),
      avancesSortie: new Object(),
      modal: false,
      modalS: false,
      avanceE: new Object(),
      avanceS: new Object(),
      token: localStorage.getItem("token"),
      commandes_en_attente: [],
      commandes_acceptees: [],
      entree: 0,
      prixModal: false,
      prix_unitaire: "",
      prix_de_vente: "",
      prix_de_vente_2: "",
      commandeT: new Object(),
      modalArticles: false,
      ArticlesCommande: [],
      modalPrixCommande: false,
      commandeAcceptee: new Object(),
      modalArticlesRecu: false,
      entreeD: new Object(),
      sortie: 0,
      sortieD: new Object()
    };
  },
  created() {
    this.avancesEntree = this.$route.params.avances.avancesEntree;
    this.avancesSortie = this.$route.params.avances.avancesSortie;
    this.commandes_en_attenteF();
    this.commandes_accepteesF();
  },
  methods: {
    saveArticleCommande(articleCommande) {
      var qte = document.getElementById("qte" + articleCommande.id);
      articleCommande.qte = qte.innerHTML
        .toString()
        .split(">")[1]
        .split("<")[0];
      fetch(`api/ModifierArticleCommande/${articleCommande.id}`, {
        method: "put",
        body: JSON.stringify(articleCommande),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(res => {})
        .catch(err => console.log(err));
    },
    articlesCommandeRecu(commande) {
      this.ArticlesCommande = commande.articles;
      this.modalArticlesRecu = true;
    },
    articlesCommande(commande) {
      this.ArticlesCommande = commande.articles;
      this.modalArticles = true;
    },
    lanceModalPrixCommande(commande) {
      this.modalPrixCommande = true;
      this.commandeAcceptee = commande;
    },
    accepte() {
      fetch(`api/accepte/${this.commandeAcceptee.id}`, {
        method: "put",
        body: JSON.stringify(this.commandeAcceptee),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          this.commandes_en_attenteF();
          this.modalPrixCommande = false;
        })
        .catch(err => console.log(err));
    },
    refuse(commande) {
      fetch(`api/refuse/${commande.id}`, {
        method: "put",
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          this.commandes_en_attenteF();
        })
        .catch(err => console.log(err));
    },
    updateStock(article) {
      fetch(`api/addStock`, {
        method: "put",
        body: JSON.stringify(article),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {})
        .catch(err => console.log(err));
    },
    removeStock(article) {
      fetch(`api/removeStock`, {
        method: "put",
        body: JSON.stringify(article),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {})
        .catch(err => console.log(err));
    },
    recuTraitementSortie(commande) {
      if (this.sortie == 0) {
        this.sortie = 1;
        this.sortieD.id_client = commande.clientO.id;
        this.sortieD.user_id = commande.fournisseurO.id;
        this.sortieD.date = this.formatDate(new Date());
        fetch("api/sortieC?token=" + this.token, {
          method: "post",
          body: JSON.stringify(this.sortieD),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {
            this.sortieD = data.data;
            //update stock
            var h;
            for (h = 0; h < commande.serie.articles.length; h++) {
              var m;
              for (m = 0; m < commande.articles.length; m++) {
                if (
                  commande.articles[m].taille ==
                  commande.serie.articles[h].taille
                ) {
                  commande.serie.articles[h].stock = commande.articles[m].qte;
                }
              }
              this.removeStock(commande.serie.articles[h]);
            }
            //ajouter ligneSortie
            var d;
            var qte = 0;
            for (d = 0; d < commande.articles.length; d++) {
              qte = Number(commande.articles[d].qte) + qte;
            }
            this.sortieD.montant_total =
              Number(this.sortieD.montant_total) + qte * Number(commande.prix);
            let ligneSortie = {
              idSortie: this.sortieD.id,
              idSerie: commande.serie.id,
              user_id: commande.fournisseurO.id,
              prix_unitaire: commande.prix,
              qte: qte
            };
            fetch("api/ligneSortieCommande?token=" + this.token, {
              method: "post",
              body: JSON.stringify(ligneSortie),
              headers: {
                "content-type": "application/json"
              }
            })
              .then(res => res.json())
              .then(data => {
                //modifier Sortie
                fetch(`api/sortie/${this.sortieD.id}`, {
                  method: "put",
                  body: JSON.stringify(this.sortieD),
                  headers: {
                    "content-type": "application/json"
                  }
                })
                  .then(res => res.json())
                  .then(data => {})
                  .catch(err => console.log(err));
                /////////////////////////
              })
              .catch(err => console.log(err));
          })
          .catch(err => console.log(err));
      } else {
        var h;
        for (h = 0; h < commande.serie.articles.length; h++) {
          var m;
          for (m = 0; m < commande.articles.length; m++) {
            if (
              commande.articles[m].taille == commande.serie.articles[h].taille
            ) {
              commande.serie.articles[h].stock = commande.articles[m].qte;
            }
          }
          this.removeStock(commande.serie.articles[h]);
        }
        //ajouter ligneSortie
        var d;
        var qte = 0;
        for (d = 0; d < commande.articles.length; d++) {
          qte = Number(commande.articles[d].qte) + qte;
        }
        this.sortieD.montant_total =
          Number(this.sortieD.montant_total) + qte * Number(commande.prix);
        let ligneSortie = {
          idSortie: this.sortieD.id,
          idSerie: commande.serie.id,
          user_id: commande.fournisseurO.id,
          prix_unitaire: commande.prix,
          qte: qte
        };
        fetch("api/ligneSortieCommande?token=" + this.token, {
          method: "post",
          body: JSON.stringify(ligneSortie),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {
            fetch(`api/sortie/${this.sortieD.id}`, {
              method: "put",
              body: JSON.stringify(this.sortieD),
              headers: {
                "content-type": "application/json"
              }
            })
              .then(res => res.json())
              .then(data => {})
              .catch(err => console.log(err));
            /////////////////////////
          })
          .catch(err => console.log(err));
      }
    },
    recuTraitement(commande) {
      if (this.entree == 0) {
        this.recuTraitementSortie(commande);
        fetch(`api/recu/${commande.id}`, {
          method: "put",
          body: JSON.stringify(commande),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {})
          .catch(err => console.log(err));
        this.entree = 1;
        this.entreeD.id_fournisseur = commande.fournisseurO.id;
        this.entreeD.user_id = commande.clientO.id;
        this.entreeD.date = this.formatDate(new Date());
        let SerieD = {
          fournisseur_id: commande.fournisseurO.id,
          photo: commande.serie.photo,
          couleur: commande.serie.couleur,
          ref: commande.serie.ref,
          genre: commande.serie.genre,
          type_serie_id: commande.serie.type_serie_id,
          articles: commande.serie.articles,
          articlesCommande: commande.articles
        };
        fetch("api/entree?token=" + this.token, {
          method: "post",
          body: JSON.stringify(this.entreeD),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {
            this.entreeD = data.data;
            let serie = {
              ref: commande.serie.ref,
              fournisseur_id: commande.fournisseurO.id,
              couleur: commande.serie.couleur
            };
            //verifier si la serie existe ou non
            fetch("api/existe?token=" + this.token, {
              method: "post",
              body: JSON.stringify(serie),
              headers: {
                "content-type": "application/json"
              }
            })
              .then(res => res.json())
              .then(data => {
                var serie_id;
                if (data == 0) {
                  //creer la serie
                  fetch("api/serieCommande?token=" + this.token, {
                    method: "post",
                    body: JSON.stringify(SerieD),
                    headers: {
                      "content-type": "application/json"
                    }
                  })
                    .then(res => res.json())
                    .then(data => {
                      serie_id = data.data.id;
                      //ajouter ligneEntree
                      var j;
                      var qte = 0;
                      for (j = 0; j < commande.articles.length; j++) {
                        qte = Number(commande.articles[j].qte) + qte;
                      }
                      this.entreeD.montant_total =
                        Number(this.entreeD.montant_total) +
                        qte * Number(commande.prix);
                      let ligneEntree = {
                        idEntree: this.entreeD.id,
                        idSerie: serie_id,
                        prix_unitaire: commande.prix,
                        prix_vente: this.prix_de_vente_2,
                        qte: qte
                      };
                      fetch("api/ligneEntree?token=" + this.token, {
                        method: "post",
                        body: JSON.stringify(ligneEntree),
                        headers: {
                          "content-type": "application/json"
                        }
                      })
                        .then(res => res.json())
                        .then(data => {
                          //modifier Entree
                          fetch(`api/entree/${this.entreeD.id}`, {
                            method: "put",
                            body: JSON.stringify(this.entreeD),
                            headers: {
                              "content-type": "application/json"
                            }
                          })
                            .then(res => res.json())
                            .then(data => {})
                            .catch(err => console.log(err));
                          /////////////////////////
                        })
                        .catch(err => console.log(err));
                    })
                    .catch(err => console.log(err));
                  /////////////////////////////////
                }
                //la serie existe deja
                else {
                  serie_id = data.data.id;
                  var i;
                  for (i = 0; i < data.data.articles.length; i++) {
                    var k;
                    for (k = 0; k < commande.articles.length; k++) {
                      if (
                        commande.articles[k].taille ==
                        data.data.articles[i].taille
                      ) {
                        data.data.articles[i].stock = commande.articles[k].qte;
                      }
                    }
                    this.updateStock(data.data.articles[i]);
                  }
                  //ajouter ligneEntree
                  var j;
                  var qte = 0;
                  for (j = 0; j < commande.articles.length; j++) {
                    qte = Number(commande.articles[j].qte) + qte;
                  }
                  this.entreeD.montant_total =
                    Number(this.entreeD.montant_total) +
                    qte * Number(commande.prix);
                  let ligneEntree = {
                    idEntree: this.entreeD.id,
                    idSerie: serie_id,
                    prix_unitaire: commande.prix,
                    prix_vente: this.prix_de_vente_2,
                    qte: qte
                  };
                  fetch("api/ligneEntree?token=" + this.token, {
                    method: "post",
                    body: JSON.stringify(ligneEntree),
                    headers: {
                      "content-type": "application/json"
                    }
                  })
                    .then(res => res.json())
                    .then(data => {
                      //modifier Entree
                      fetch(`api/entree/${this.entreeD.id}`, {
                        method: "put",
                        body: JSON.stringify(this.entreeD),
                        headers: {
                          "content-type": "application/json"
                        }
                      })
                        .then(res => res.json())
                        .then(data => {
                          this.commandes_accepteesF();
                          this.prixModal = false;
                        })
                        .catch(err => console.log(err));
                      /////////////////////////
                    })
                    .catch(err => console.log(err));
                }
              })
              .catch(err => console.log(err));
            //////////////////////////////////////////
          })
          .catch(err => console.log(err));
      } else {
        if (commande.fournisseurO.id == this.entreeD.fournisseur.id) {
          fetch(`api/recu/${commande.id}`, {
            method: "put",
            body: JSON.stringify(commande),
            headers: {
              "content-type": "application/json"
            }
          })
            .then(res => res.json())
            .then(data => {})
            .catch(err => console.log(err));
          this.recuTraitementSortie(commande);
          let serie = {
            ref: commande.serie.ref,
            fournisseur_id: commande.fournisseurO.id,
            couleur: commande.serie.couleur
          };
          //verifier si la serie existe ou non
          fetch("api/existe?token=" + this.token, {
            method: "post",
            body: JSON.stringify(serie),
            headers: {
              "content-type": "application/json"
            }
          })
            .then(res => res.json())
            .then(data => {
              var serie_id;
              if (data == 0) {
                //creer la serie
                fetch("api/serieCommande?token=" + this.token, {
                  method: "post",
                  body: JSON.stringify(SerieD),
                  headers: {
                    "content-type": "application/json"
                  }
                })
                  .then(res => res.json())
                  .then(data => {
                    serie_id = data.data.id;
                    //ajouter ligneEntree
                    var j;
                    var qte = 0;
                    for (j = 0; j < commande.articles.length; j++) {
                      qte = Number(commande.articles[j].qte) + qte;
                    }
                    this.entreeD.montant_total =
                      Number(this.entreeD.montant_total) +
                      qte * Number(commande.prix);
                    let ligneEntree = {
                      idEntree: this.entreeD.id,
                      idSerie: serie_id,
                      prix_unitaire: commande.prix,
                      prix_vente: this.prix_de_vente_2,
                      qte: qte
                    };
                    fetch("api/ligneEntree?token=" + this.token, {
                      method: "post",
                      body: JSON.stringify(ligneEntree),
                      headers: {
                        "content-type": "application/json"
                      }
                    })
                      .then(res => res.json())
                      .then(data => {
                        //modifier Entree
                        fetch(`api/entree/${this.entreeD.id}`, {
                          method: "put",
                          body: JSON.stringify(this.entreeD),
                          headers: {
                            "content-type": "application/json"
                          }
                        })
                          .then(res => res.json())
                          .then(data => {})
                          .catch(err => console.log(err));
                        /////////////////////////
                      })
                      .catch(err => console.log(err));
                  })
                  .catch(err => console.log(err));
                /////////////////////////////////
              }
              //la serie existe deja
              else {
                serie_id = data.data.id;
                var i;
                for (i = 0; i < data.data.articles.length; i++) {
                  var k;
                  for (k = 0; k < commande.articles.length; k++) {
                    if (
                      commande.articles[k].taille ==
                      data.data.articles[i].taille
                    ) {
                      data.data.articles[i].stock = commande.articles[k].qte;
                    }
                  }
                  this.updateStock(data.data.articles[i]);
                }
                //ajouter ligneEntree
                var j;
                var qte = 0;
                for (j = 0; j < commande.articles.length; j++) {
                  qte = Number(commande.articles[j].qte) + qte;
                }
                this.entreeD.montant_total =
                  Number(this.entreeD.montant_total) +
                  qte * Number(commande.prix);
                let ligneEntree = {
                  idEntree: this.entreeD.id,
                  idSerie: serie_id,
                  prix_unitaire: commande.prix,
                  prix_vente: this.prix_de_vente_2,
                  qte: qte
                };
                fetch("api/ligneEntree?token=" + this.token, {
                  method: "post",
                  body: JSON.stringify(ligneEntree),
                  headers: {
                    "content-type": "application/json"
                  }
                })
                  .then(res => res.json())
                  .then(data => {
                    //modifier Entree
                    fetch(`api/entree/${this.entreeD.id}`, {
                      method: "put",
                      body: JSON.stringify(this.entreeD),
                      headers: {
                        "content-type": "application/json"
                      }
                    })
                      .then(res => res.json())
                      .then(data => {
                        this.commandes_accepteesF();
                        this.prixModal = false;
                      })
                      .catch(err => console.log(err));
                    /////////////////////////
                  })
                  .catch(err => console.log(err));
              }
            })
            .catch(err => console.log(err));
        } else {
          this.$notification.success(
            "لقد أتممت المعاملة الأولى المرجو الذهاب إلى الواردات",
            {
              timer: 10
            }
          );
        }
      }
    },
    recu(commande) {
      fetch(`api/returnPrix/${commande.serie.id}`)
        .then(res => res.json())
        .then(res => {
          this.prix_unitaire = res.prix_achat;
          this.prix_de_vente = res.prix_de_vente;
        })
        .catch(err => console.log(err));
      this.commandeT = commande;
      this.prixModal = true;
    },
    non_recu(commande) {
      fetch(`api/nonRecu/${commande.id}`, {
        method: "put",
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          this.commandes_accepteesF();
        })
        .catch(err => console.log(err));
    },
    commandes_en_attenteF() {
      fetch("/api/commandes_en_attente?token=" + this.token)
        .then(res => res.json())
        .then(res => {
          this.commandes_en_attente = res.data;
        })
        .catch(err => console.log(err));
    },
    commandes_accepteesF() {
      fetch("/api/commandes_acceptees?token=" + this.token)
        .then(res => res.json())
        .then(res => {
          this.commandes_acceptees = res.data;
        })
        .catch(err => console.log(err));
    },
    okEntree(avance) {
      fetch(`api/valider/${avance.id}`, {
        method: "put",
        body: JSON.stringify(this.user),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          fetch(`api/ajouterPartie/${avance.entree.id}`, {
            method: "put",
            body: JSON.stringify({ montant_paye: avance.montant }),
            headers: {
              "content-type": "application/json"
            }
          })
            .then(res => res.json())
            .then(data => {
              this.updateVueE();
            })
            .catch(err => console.log(err));
        })
        .catch(err => console.log(err));
    },
    noEntree(avance) {
      this.avanceE = avance;
      this.modal = true;
    },
    noSortie(avance) {
      this.avanceS = avance;
      this.modalS = true;
    },
    saveE() {
      fetch(`api/AvanceEntree/${this.avanceE.id}`, {
        method: "put",
        body: JSON.stringify(this.avanceE),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          this.modal = false;
          this.updateVueE();
        })
        .catch(err => console.log(err));
    },
    saveS() {
      fetch(`api/AvanceSortie/${this.avanceS.id}`, {
        method: "put",
        body: JSON.stringify(this.avanceS),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          this.modalS = false;
          this.updateVueS();
        })
        .catch(err => console.log(err));
    },
    updateVueE() {
      let date = { date: this.formatDate(new Date()) };

      fetch("api/avancesEntreeNotif?token=" + this.token, {
        method: "post",
        body: JSON.stringify(date),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          this.avancesEntree = data.data;
        })
        .catch(err => console.log(err));
    },
    updateVueS() {
      let date = { date: this.formatDate(new Date()) };

      fetch("api/avancesSortieNotif?token=" + this.token, {
        method: "post",
        body: JSON.stringify(date),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          this.avancesSortie = data.data;
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
    okSortie(avance) {
      fetch(`api/validerS/${avance.id}`, {
        method: "put",
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          fetch(`api/ajouterPartieS/${avance.sortie.id}`, {
            method: "put",
            body: JSON.stringify({ montant_paye: avance.montant }),
            headers: {
              "content-type": "application/json"
            }
          })
            .then(res => res.json())
            .then(data => {
              this.updateVueS();
            })
            .catch(err => console.log(err));
        })
        .catch(err => console.log(err));
    }
  }
};
</script>
