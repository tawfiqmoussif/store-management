<!--<template>
  <div class="content" style="direction: ltr !important; ">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-size-160">
        <vue-good-wizard
          :steps="pages"
          :onNext="nextClicked"
          :onBack="backClicked"
          finalStepLabel="حفظ"
          nextStepLabel="التالي"
          previousStepLabel="السابق"
        >
          <div :slot="page.slot" :key="page.n" v-for="page in pages">
            <div
              class="md-layout"
              style="margin-top:30px; direction: rtl !important; "
            >
              <div class="md-layout-item md-small-size-100 md-size-33">
                <md-field>
                  <label>نوع البضاعة</label>
                  <md-select v-model="selected">
                    <md-option value=0
                    ></md-option>
                    <md-option
                      v-for="serie in series"
                      :key="serie.id"
                      :value="serie.id"
                    >{{serie.ref}} {{serie.couleur}}</md-option>
                  </md-select>
                </md-field>
              </div>
              <div class="md-layout-item md-small-size-100 md-size-33">
                <md-field>
                  <label>الثمن</label>
                  <md-input type="text" v-model="ligne.prix_unitaire"></md-input>
                </md-field>
              </div>
              <div class="md-layout-item md-small-size-100 md-size-33">
                <md-field>
                  <label>العدد</label>
                  <md-input type="number" v-model="qte"></md-input>
                </md-field>
              </div>

              <div class="md-layout-item md-small-size-100 md-size-100">
                <mdb-tbl bordered>
                  <mdb-tbl-head color="light">
                    <tr>
                      <th
                        scope="col"
                        v-for="article in articles"
                        :key="article.id"
                      >{{article.taille}}</th>
                    </tr>
                  </mdb-tbl-head>
                  <mdb-tbl-body>
                    <tr>
                      <td v-for="article in articles" :key="article.id">
                        <input style="width:40px;" v-model="article.stock" />
                      </td>
                    </tr>
                  </mdb-tbl-body>
                </mdb-tbl>
              </div>
              <div v-if="display" class="md-layout-item md-small-size-100 md-size-100">
                <md-button  class="md-raised md-success" @click="AjouterLigne()">إضافة</md-button>
              </div>
            </div>
          </div>
        </vue-good-wizard>
      </div>
    </div>
  </div>
</template>

<script>
import { mdbTbl, mdbTblHead, mdbTblBody, mdbScrollbar } from "mdbvue";
export default {
  name: "demo",
  components: {
    mdbTbl,
    mdbTblHead,
    mdbTblBody,
    mdbScrollbar
  },
  data() {
    return {
      pages: [],
      n: 0,
      change:0,
      componentKey: 0,
      series: null,
      Entree: null,
      display: false,
      articles: new Object(),
      selected: 0,
      prix: "",
      qte: "",
      ligne: {
        idEntree: this.$route.params.object.Entree.id,
        idSerie: "",
        prix_unitaire: "",
        qte: ""
      }
    };
  },
  created() {
    this.series = this.$route.params.object.Fournisseur.series;
    this.n = this.$route.params.object.nbr;
    this.Entree = this.$route.params.object.Entree;
    var i;
    for (i = 0; i < this.n; i++) {
      this.pages.push({ n: i + 1, slot: "page" + (i + 1) });
    }
  },
  methods: {
    forceRerender() {
      this.componentKey += 1;
    },
    clearForm() {
      this.qte = "";
    },
    nextClicked(currentPage) {
      this.selected=0;
      this.display=false;
      if (currentPage == this.n - 1) 
      {
       fetch(`api/entree/${this.Entree.id}`,
          {
          method: "put",
          body: JSON.stringify(this.Entree),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {})
          .catch(err => console.log(err));
      }
      return true; //return false if you want to prevent moving to next page
    },
    backClicked(currentPage) {
     // this.forceRerender();
      return true; //return false if you want to prevent moving to previous page
    },
    updateStock(article){
         fetch(`api/addStock`, {
              method: "put",
              body: JSON.stringify(article),
              headers: {
                "content-type": "application/json"
              }
            })
              .then(res => res.json())
              .then(data => {
              })
              .catch(err => console.log(err));
    },
    AjouterLigne() {
      this.ligne.idSerie = this.selected;
      this.ligne.qte = this.qte;
      this.Entree.montant_total =
        this.Entree.montant_total + this.ligne.prix_unitaire * this.ligne.qte;
        console.log(this.Entree);

      fetch("api/ligneEntree", {
        method: "post",
        body: JSON.stringify(this.ligne),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          var i;
          for (i = 0; i < this.articles.length; i++) {
             this.updateStock(this.articles[i]);
          }
          this.clearForm();
        })
        .catch(err => console.log(err));
    }
  },
  watch: {
    selected: function(event) {
      fetch(`api/returnTailles/${this.selected}`)
        .then(res => res.json())
        .then(res => {
          this.articles = res.data;
          this.display = true;
        })
        .catch(err => console.log(err));
    },
    qte: function(event) {
      let stock = this.qte / this.articles.length;
      var i;
      for (i = 0; i < this.articles.length; i++) {
        this.articles[i].stock = stock;
      }
    },
     change: function(event) {
      this.display=false;
    }
  }
};
</script>-->
<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-size-66">
        <form novalidate @submit.prevent="addSerie" enctype="multipart/form-data">
          <md-card>
            <md-card-header data-background-color="green">
              <h4 class="title">انواع البضاعة</h4>
              <p class="category">تدبير انواع البضاعة</p>
            </md-card-header>

            <md-card-content>
              <div class="md-layout">
                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field>
                    <label>نوع البضاعة</label>
                    <md-select v-model="selected">
                      <md-option value="0"></md-option>
                      <md-option
                        v-for="serie in series"
                        :key="serie.id"
                        :value="serie.id"
                      >{{serie.ref}} {{serie.couleur}}</md-option>
                    </md-select>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field>
                    <label>الثمن</label>
                    <md-input type="text" v-model="ligne.prix_unitaire"></md-input>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field>
                    <label>العدد</label>
                    <md-input type="number" v-model="qte"></md-input>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-100">
                  <mdb-tbl bordered>
                    <mdb-tbl-head color="light">
                      <tr>
                        <th
                          scope="col"
                          v-for="article in articles"
                          :key="article.id"
                        >{{article.taille}}</th>
                      </tr>
                    </mdb-tbl-head>
                    <mdb-tbl-body>
                      <tr>
                        <td v-for="article in articles" :key="article.id">
                          <input style="width:40px;" v-model="article.stock" />
                        </td>
                      </tr>
                    </mdb-tbl-body>
                  </mdb-tbl>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-100">
                  <md-button class="md-raised md-success" @click="AjouterLigne()">إضافة</md-button>
                  <md-button class="md-raised md-success" @click="onExit()">خروج</md-button>
                </div>
              </div>
            </md-card-content>
            <md-progress-bar md-mode="indeterminate" v-if="sending2" />
          </md-card>
          <md-snackbar :md-active.sync="sending" :md-duration="4000">لقد تمت الإضافة بنجاح</md-snackbar>
        </form>
       <mdb-modal :show="modalEchange" @close="modalEchange = false">
          <mdb-modal-header>
            <mdb-modal-title></mdb-modal-title>
          </mdb-modal-header>
          <mdb-modal-body>
            <p>هذا الزبون تدين له ب {{sommeFournisseur}} درهم وأنت بعت له بضاعة بقيمة {{Sortie.montant_total}} درهم</p>
            <p>هل تريد احتساب هذه المعاملة كمبادلة؟</p>
          </mdb-modal-body>
          <mdb-modal-footer>
            <mdb-btn color="secondary" style="margin :10px;" @click="ok">نعم</mdb-btn>
            <mdb-btn color="primary" style="margin :10px;" @click="no">لا</mdb-btn>
          </mdb-modal-footer>
        </mdb-modal>
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
  name: "demo",
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
  data() {
    return {
      change: 0,
      componentKey: 0,
      series: null,
      Sortie: null,
      articles: new Object(),
      selected: 0,
      sending2: false,
      sending: false,
      prix: "",
      qte: "",
      ligne: {
        idSortie: this.$route.params.object.Sortie.id,
        idSerie: "",
        prix_unitaire: "",
        qte: ""
      },
      token: localStorage.getItem("token"),
      modalEchange: false,
      sommeFournisseur: 0,
      sommeClient: 0
    };
  },
  created() {
    this.fetchSeries();
    this.Sortie = this.$route.params.object.Sortie;
  },
  methods: {
    forceRerender() {
      this.componentKey += 1;
    },
    clearForm() {
      this.qte = "";
    },
    fetchSeries() {
      fetch("api/series?token=" + this.token)
        .then(res => res.json())
        .then(res => {
          this.series = res.data;
        })
        .catch(err => console.log(err));
    },
    updateStock(article) {
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
    AjouterLigne() {
      this.sending2 = true;
      this.sending = true;
      this.ligne.idSerie = this.selected;
      this.ligne.qte = this.qte;
      this.Sortie.montant_total =
        this.Sortie.montant_total + this.ligne.prix_unitaire * this.ligne.qte;

      fetch("api/ligneSortie?token=" + this.token, {
        method: "post",
        body: JSON.stringify(this.ligne),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          var i;
          for (i = 0; i < this.articles.length; i++) {
            this.updateStock(this.articles[i]);
          }
          this.clearForm();
          this.sending2 = false;
          //updateSortie
          fetch(`api/sortie/${this.Sortie.id}`, {
            method: "put",
            body: JSON.stringify(this.Sortie),
            headers: {
              "content-type": "application/json"
            }
          })
            .then(res => res.json())
            .then(data => {})
            .catch(err => console.log(err));
        })
        .catch(err => console.log(err));
    },
    onExit() {
     fetch(`/api/sommeClient/${this.Sortie.client.id}?token=` + this.token)
        .then(res => res.json())
        .then(res => {
          this.sommeClient = res.sommeClient;
          this.sommeFournisseur = res.sommeFournisseur;
          if (this.sommeFournisseur - this.sommeClient >=  0) {
            this.modalEchange = true;
          }
          else {
            this.$router.push({ name: "sorties" });
          }
        })
        .catch(err => console.log(err));
    },
    ok() {
      if (this.sommeFournisseur >= this.Sortie.montant_total) {
        this.Sortie.montant = this.Sortie.montant_total;
      } else if (this.sommeFournisseur < this.Sortie.montant_total) {
        this.Sortie.montant = this.sommeFournisseur;
      }
     /* let AvanceSortie = {
        sortie_id: this.Sortie.id,
        type_paiement: "مبادلة",
        date: this.formatDate(new Date()),
        description: "مبادلة",
        montant: this.Sortie.montant
      };
      fetch("api/AvanceSortie?token=" + this.token, {
        method: "post",
        body: JSON.stringify(AvanceSortie),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          this.$router.push({ name: "sorties" });
        })

        .catch(err => console.log(err));*/

      fetch(`api/sortie/${this.Sortie.id}`, {
        method: "put",
        body: JSON.stringify(this.Sortie),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          ////////////////////:
        let AvanceSortie = {
        sortie_id: this.Sortie.id,
        type_paiement: "مبادلة",
        date: this.formatDate(new Date()),
        description: "مبادلة",
        montant: this.Sortie.montant
      };
      fetch("api/AvanceSortie?token=" + this.token, {
        method: "post",
        body: JSON.stringify(AvanceSortie),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(data => {
          this.$router.push({ name: "sorties" });
        })

        .catch(err => console.log(err));
        /////////////////////////////:
        })
        .catch(err => console.log(err));
  
    },
    no() {
      this.modalEchange = false;
      this.$router.push({ name: "sorties" });
    }
  },
  watch: {
    selected: function(event) {
      fetch(`api/returnTailles/${this.selected}`)
        .then(res => res.json())
        .then(res => {
          this.articles = res.data;
        })
        .catch(err => console.log(err));
    },
    qte: function(event) {
      let stock = this.qte / this.articles.length;
      var i;
      for (i = 0; i < this.articles.length; i++) {
        this.articles[i].stock = stock;
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
        