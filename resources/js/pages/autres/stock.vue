<template>
  <div class="content" style="direction: ltr !important; ">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-size-160">
        <mdb-tabs
          :active="0"
          default
          :links="[
      { text: 'النساء' },
      { text: 'الرجال' },
      { text: 'الأطفال' }]"
          :transition-duration="0.5"
          transition-style="linear"
        >
          <template :slot="'النساء'">
            <div class="row" style=" margin-top:10px;">
              <div class="md-layout-item md-size-20">
                <md-autocomplete v-model="refFemme" :md-options="refs" md-layout="box" md-dense>
                  <label>نوع البضاعة</label>
                </md-autocomplete>
              </div>
              <div class="md-layout-item md-size-20">
                <md-autocomplete
                  v-model="couleurFemme"
                  :md-options="couleurs"
                  md-layout="box"
                  md-dense
                >
                  <label>اللون</label>
                </md-autocomplete>
              </div>
              <div class="md-layout-item md-size-20">
                <md-autocomplete
                  v-model="marqueFemme"
                  :md-options="marques"
                  md-layout="box"
                  md-dense
                >
                  <label>المورد</label>
                </md-autocomplete>
              </div>
              <div class="md-layout-item md-size-20">
                <md-autocomplete
                  v-model="tailleFemme"
                  :md-options="femmeTailles"
                  md-layout="box"
                  md-dense
                >
                  <label>رقم الحذاء</label>
                </md-autocomplete>
              </div>
              <div class="md-layout-item md-size-20">
                <md-autocomplete
                  v-model="type_femme"
                  :md-options="libeles"
                  md-layout="box"
                  md-dense
                >
                  <label>نوع الحذاء</label>
                </md-autocomplete>
              </div>
            </div>
            <div class="row" style="margin-left: 50px;">
              <div
                class="card"
                style="width: 18rem; margin-left: 10px; margin-top: 10px;"
                v-for="serieF in paginedF"
                :key="serieF.id"
              >
                <img
                  class="card-img-top"
                  :src="'/photoSerie/'+serieF.photo"
                  alt="Card image cap"
                  style="height: 10rem;"
                />
                <div class="card-body">
                  <h5 class="card-title">{{serieF.fournisseur.nom_marque}} {{serieF.ref}}</h5>
                  <md-button @click="articles(serieF)" class="md-success md-just-icon md-round">
                    <md-icon>menu</md-icon>
                  </md-button>
                  <md-button class="md-warning md-just-icon md-round" @click="commande(serieF)">
                    <i class="fas fa-check"></i>
                  </md-button>
                </div>
              </div>
            </div>
            <!-- pagination -->
            <div
              class="md-layout-item md-small-size-100 md-size-40"
              style="margin-top:20px;margin-left: 300px;display: flex;justify-content: center;direction: rtl !important;"
            >
              <mdb-btn
                style="border-color: #4caf50;background-color: #4caf50 !important;"
                color="success"
                :disabled="pageF === 0"
                @click="precF()"
              >
                <i class="fas fa-forward"></i>
                السابق
              </mdb-btn>
              <p
                v-if="this.filtredF.length>0"
                style="margin-top: 20px;"
              >{{ pageF + 1 }} من {{ Math.ceil(this.filtredF.length/this.itemsPerPageF) }}</p>
              <mdb-btn
                style="border-color: #4caf50;background-color: #4caf50 !important;"
                color="success"
                :disabled="pageF === Math.ceil(this.filtredF.length/this.itemsPerPageF)-1 || this.filtredF.length==0"
                @click="suivF()"
              >
                التالي
                <i class="fas fa-backward"></i>
              </mdb-btn>
            </div>
            <!--------------------------------------------------------->
          </template>
          <template :slot="'الرجال'">
            <div class="row" style=" margin-top:10px;">
              <div class="md-layout-item md-size-20">
                <md-autocomplete v-model="refHomme" :md-options="refs" md-layout="box" md-dense>
                  <label>نوع البضاعة</label>
                </md-autocomplete>
              </div>
              <div class="md-layout-item md-size-20">
                <md-autocomplete
                  v-model="couleurHomme"
                  :md-options="couleurs"
                  md-layout="box"
                  md-dense
                >
                  <label>اللون</label>
                </md-autocomplete>
              </div>
              <div class="md-layout-item md-size-20">
                <md-autocomplete
                  v-model="marqueHomme"
                  :md-options="marques"
                  md-layout="box"
                  md-dense
                >
                  <label>المورد</label>
                </md-autocomplete>
              </div>
              <div class="md-layout-item md-size-20">
                <md-autocomplete
                  v-model="tailleHomme"
                  :md-options="HommeTailles"
                  md-layout="box"
                  md-dense
                >
                  <label>رقم الحذاء</label>
                </md-autocomplete>
              </div>
              <div class="md-layout-item md-size-20">
                <md-autocomplete
                  v-model="type_homme"
                  :md-options="libeles"
                  md-layout="box"
                  md-dense
                >
                  <label>نوع الحذاء</label>
                </md-autocomplete>
              </div>
            </div>
            <div class="row" style="margin-left: 50px;">
              <div
                class="card"
                style="width: 18rem; margin-left: 10px; margin-top: 10px;"
                v-for="serieH in paginedH"
                :key="serieH.id"
              >
                <img
                  class="card-img-top"
                  :src="'/photoSerie/'+serieH.photo"
                  alt="Card image cap"
                  style="height: 10rem;"
                />
                <div class="card-body">
                  <h5 class="card-title">{{serieH.ref}} {{serieH.fournisseur.nom_marque}}</h5>
                  <md-button @click="articles(serieH)" class="md-success md-just-icon md-round">
                    <md-icon>menu</md-icon>
                  </md-button>
                  <md-button class="md-warning md-just-icon md-round" @click="commande(serieH)">
                    <i class="fas fa-check"></i>
                  </md-button>
                </div>
              </div>
            </div>
            <!-- pagination -->
            <div
              class="md-layout-item md-small-size-100 md-size-40"
              style="margin-top:20px;margin-left: 300px;display: flex;justify-content: center;direction: rtl !important;"
            >
              <mdb-btn
                style="border-color: #4caf50;background-color: #4caf50 !important;"
                color="success"
                :disabled="pageH === 0"
                @click="precH()"
              >
                <i class="fas fa-forward"></i>
                السابق
              </mdb-btn>
              <p
                v-if="this.filtredH.length>0"
                style="margin-top: 20px;"
              >{{ pageH + 1 }} من {{ Math.ceil(this.filtredH.length/this.itemsPerPageH) }}</p>
              <mdb-btn
                style="border-color: #4caf50;background-color: #4caf50 !important;"
                color="success"
                :disabled="pageH === Math.ceil(this.filtredH.length/this.itemsPerPageH)-1 || this.filtredH.length==0"
                @click="suivH()"
              >
                التالي
                <i class="fas fa-backward"></i>
              </mdb-btn>
            </div>
            <!--------------------------------------------------------->
          </template>
          <template :slot="'الأطفال'">
            <div class="row" style="margin-top:10px;">
              <div class="md-layout-item md-size-20">
                <md-autocomplete v-model="refEnfant" :md-options="refs" md-layout="box" md-dense>
                  <label>نوع البضاعة</label>
                </md-autocomplete>
              </div>
              <div class="md-layout-item md-size-20">
                <md-autocomplete
                  v-model="couleurEnfant"
                  :md-options="couleurs"
                  md-layout="box"
                  md-dense
                >
                  <label>اللون</label>
                </md-autocomplete>
              </div>
              <div class="md-layout-item md-size-20">
                <md-autocomplete
                  v-model="marqueEnfant"
                  :md-options="marques"
                  md-layout="box"
                  md-dense
                >
                  <label>المورد</label>
                </md-autocomplete>
              </div>
              <div class="md-layout-item md-size-20">
                <md-autocomplete
                  v-model="tailleEnfant"
                  :md-options="enfantTailles"
                  md-layout="box"
                  md-dense
                >
                  <label>رقم الحذاء</label>
                </md-autocomplete>
              </div>
              <div class="md-layout-item md-size-20">
                <md-autocomplete
                  v-model="type_enfant"
                  :md-options="libeles"
                  md-layout="box"
                  md-dense
                >
                  <label>نوع الحذاء</label>
                </md-autocomplete>
              </div>
            </div>

            <div class="row" style="margin-left: 50px;">
              <div
                class="card"
                style="width: 18rem; margin-left: 10px; margin-top: 10px;"
                v-for="serieE in paginedE"
                :key="serieE.id"
              >
                <img
                  class="card-img-top"
                  :src="'/photoSerie/'+serieE.photo"
                  alt="Card image cap"
                  style="height: 10rem;"
                />
                <div class="card-body">
                  <h5 class="card-title">{{serieE.ref}} {{serieE.fournisseur.nom_marque}}</h5>
                  <md-button @click="articles(serieE)" class="md-success md-just-icon md-round">
                    <md-icon>menu</md-icon>
                  </md-button>
                  <md-button class="md-warning md-just-icon md-round" @click="commande(serieE)">
                    <i class="fas fa-check"></i>
                  </md-button>
                </div>
              </div>
            </div>
            <!-- pagination -->
            <div
              class="md-layout-item md-small-size-100 md-size-40"
              style="margin-top:20px;margin-left: 300px;display: flex;justify-content: center;direction: rtl !important;"
            >
              <mdb-btn
                style="border-color: #4caf50;background-color: #4caf50 !important;"
                color="success"
                :disabled="pageE === 0"
                @click="precE()"
              >
                <i class="fas fa-forward"></i>
                السابق
              </mdb-btn>
              <p
                v-if="this.filtredE.length>0"
                style="margin-top: 20px;"
              >{{ pageE + 1 }} من {{ Math.ceil(this.filtredE.length/this.itemsPerPageE) }}</p>
              <mdb-btn
                style="border-color: #4caf50;background-color: #4caf50 !important;"
                color="success"
                :disabled="pageE === Math.ceil(this.filtredE.length/this.itemsPerPageE)-1 || this.filtredE.length==0"
                @click="suivE()"
              >
                التالي
                <i class="fas fa-backward"></i>
              </mdb-btn>
            </div>
            <!--------------------------------------------------------->
          </template>
        </mdb-tabs>
        <mdb-modal
          :show="modalArticles"
          @close="modalArticles = false"
          style="direction: rtl !important;"
        >
          <mdb-modal-header>
            <mdb-modal-title></mdb-modal-title>
          </mdb-modal-header>
          <mdb-modal-body>
            <md-table table-header-color="green" v-model="articlesSerie">
              <md-table-row slot="md-table-row" slot-scope="{ item }">
                <md-table-cell md-label="رقم الحذاء">{{item.taille}}</md-table-cell>
                <md-table-cell md-label="المخزون">{{item.stock}}</md-table-cell>
                <!--<md-table-cell md-label="اختيار">
              <md-button
                @click="goToEditAvance(item)"
                data-toggle="modal"
                data-target="#exampleModal3"
                class="md-warning md-just-icon md-round"
              >
                <md-icon>edit</md-icon>
              </md-button>
                </md-table-cell>-->
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
        <!----modal commande--->
        <mdb-modal
          :show="modalCommande"
          @close="modalCommande = false"
          style="direction: rtl !important;"
        >
          <mdb-modal-header>
            <mdb-modal-title>المرجو إدخال الكمية المطلوبة لكل مقاس</mdb-modal-title>
          </mdb-modal-header>
          <mdb-modal-body>
            <div class="md-layout-item md-small-size-100 md-size-100">
              <mdb-tbl bordered>
                <mdb-tbl-head color="light">
                  <tr>
                    <th
                      scope="col"
                      v-for="article in articlesSerie"
                      :key="article.id"
                    >{{article.taille}}</th>
                  </tr>
                </mdb-tbl-head>
                <mdb-tbl-body>
                   <tr>
                    <td v-for="article in articlesSerie" :key="article.id">
                      {{article.stock}}
                    </td>
                  </tr>
                  <tr>
                    <td v-for="article in articlesSerie" :key="article.id">
                      <input style="width:40px;" v-model="article.stockCommande" />
                    </td>
                  </tr>
                </mdb-tbl-body>
              </mdb-tbl>
            </div>
          </mdb-modal-body>
          <mdb-modal-footer>
            <mdb-btn color="primary" style="margin :10px;" @click="AjouterCommande()">طلب</mdb-btn>
            <mdb-btn
              color="secondary"
              style="margin :10px;"
              @click.native="modalCommande = false"
            >إغلاق</mdb-btn>
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
  mdbContainer,
  mdbCol,
  mdbRow,
  mdbIcon,
  mdbTabs,
  mdbJumbotron,
  mdbView,
  mdbMask,
  mdbBtn,
  mdbTextarea,
  mdbInput,
  mdbCarousel,
  mdbCarouselItem,
  mdbModal,
  mdbModalHeader,
  mdbModalTitle,
  mdbModalBody,
  mdbModalFooter
} from "mdbvue";

export default {
  name: "TabPage",
  components: {
    mdbTbl,
    mdbTblHead,
    mdbTblBody,
    mdbContainer,
    mdbCol,
    mdbRow,
    mdbIcon,
    mdbTabs,
    mdbJumbotron,
    mdbView,
    mdbMask,
    mdbTextarea,
    mdbInput,
    mdbCarouselItem,
    mdbCarousel,
    mdbModal,
    mdbModalHeader,
    mdbModalTitle,
    mdbModalBody,
    mdbModalFooter,
    mdbBtn
  },
  data() {
    return {
      seriesF: [],
      seriesH: [],
      seriesE: [],
      serie: {
        magasin_id: "",
        ref: "",
        couleur: "",
        genre: ""
      },
      femmeTailles: ["35", "36", "37", "38", "39"],
      HommeTailles: ["35", "36", "37", "38", "39"],
      enfantTailles: ["35", "36", "37", "38", "39"],
      couleurs: [
        "أسود",
        "أبيض",
        "رمادي",
        "أزرق",
        "أخضر",
        "أحمر",
        "بنفسجي",
        "وردي",
        "أصفر"
      ],
      selectedEmployee: null,
      couleurFemme: "",
      tailleFemme: "",
      marqueFemme: "",
      refFemme: "",
      type_femme: "",
      couleurHomme: "",
      tailleHomme: "",
      marqueHomme: "",
      refHomme: "",
      type_homme: "",
      couleurEnfant: "",
      tailleEnfant: "",
      marqueEnfant: "",
      refEnfant: "",
      type_enfant: "",
      refs: [],
      libeles: [],
      marques: [],
      //
      pageF: 0,
      itemsPerPageF: 3,
      pageH: 0,
      itemsPerPageH: 3,
      pageE: 0,
      itemsPerPageE: 3,
      user: new Object(),
      modalArticles: false,
      articlesSerie: new Object(),
      modalCommande: false,
      date: this.formatDate(new Date()),
      token: localStorage.getItem("token"),
      serieCommande: new Object()
    };
  },
  created() {
    this.user = this.$route.params.user;
    this.fetchSeriesF();
    this.fetchSeriesE();
    this.fetchSeriesH();
    this.fetchRefs();
    this.fetchLibeles();
    this.fetchMarques();
  },
  methods: {
    suivF() {
      this.pageF = this.pageF + 1;
    },
    precF() {
      this.pageF = this.pageF - 1;
    },
    suivH() {
      this.pageH = this.pageH + 1;
    },
    precH() {
      this.pageH = this.pageH - 1;
    },
    suivE() {
      this.pageE = this.pageE + 1;
    },
    precE() {
      this.pageE = this.pageE - 1;
    },
    paginateF() {
      return this.filtredF.slice(
        this.pageF * this.itemsPerPageF,
        this.itemsPerPageF * this.pageF + this.itemsPerPageF
      );
    },
    paginateH() {
      return this.filtredH.slice(
        this.pageH * this.itemsPerPageH,
        this.itemsPerPageH * this.pageH + this.itemsPerPageH
      );
    },
    paginateE() {
      return this.filtredE.slice(
        this.pageE * this.itemsPerPageE,
        this.itemsPerPageE * this.pageE + this.itemsPerPageE
      );
    },
    articles(serie) {
      //this.$router.push({ name: "articles", params: { serie } });
      this.articlesSerie = serie.articles;
      this.modalArticles = true;
    },
    commande(serie) {
      //this.$router.push({ name: "articles", params: { serie } });
      this.articlesSerie = serie.articles;
      this.serieCommande = serie;
      this.modalCommande = true;
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
    commander(commande) {
        fetch("api/AjouterArticleCommande?token=" + this.token, {
            method: "post",
            body: JSON.stringify(commande),
            headers: {
              "content-type": "application/json"
            }
          })
            .then(res => res.json())
            .then(data => {
            })

            .catch(err => console.log(err));
    },
    AjouterCommande() {
        var i;
        var message="";
        var flag = false;
        for(i=0;i<this.articlesSerie.length;i++) {
            if(this.articlesSerie[i].stockCommande > this.articlesSerie[i].stock) {
                flag = true;
                this.$notification.error("الكمية المطلوبة في المقاس "+this.articlesSerie[i].taille +"أكبر من الكمية المتاحة", {
                timer: 10
              });
            }
        }
        if(flag == false) {
          let commande = {
                    date: this.date,
                    serie_id: this.serieCommande.id,
                    fournisseur: this.user.id,
                }
             fetch("api/AjouterCommande?token=" + this.token, {
            method: "post",
            body: JSON.stringify(commande),
            headers: {
              "content-type": "application/json"
            }
          })
            .then(res => res.json())
            .then(data => {
              for(i=0;i<this.articlesSerie.length;i++) 
            {
                let ArticleCommande = {
                    commande_id: data.data.id,
                    taille: this.articlesSerie[i].taille,
                    qte: this.articlesSerie[i].stockCommande,
                }
                this.commander(ArticleCommande);
            }
            })

            .catch(err => console.log(err));
            /*for(i=0;i<this.articlesSerie.length;i++) 
            {
                let commande = {
                    date: this.date,
                    article_id: this.articlesSerie[i].id,
                    fournisseur: this.user.id,
                    qte: this.articlesSerie[i].stockCommande,
                }
                this.commander(commande);
            }*/
            this.modalCommande = false;
        }
    },
    fetchRefs() {
      fetch("/api/refs")
        .then(res => res.json())
        .then(res => {
          this.refs = res;
        })
        .catch(err => console.log(err));
    },
    fetchLibeles() {
      fetch("/api/libeles")
        .then(res => res.json())
        .then(res => {
          this.libeles = res;
        })
        .catch(err => console.log(err));
    },
    fetchMarques() {
      fetch("/api/marques")
        .then(res => res.json())
        .then(res => {
          this.marques = res;
        })
        .catch(err => console.log(err));
    },
    fetchSeriesF() {
      fetch("/api/femmesU/" + this.user.id)
        .then(res => res.json())
        .then(res => {
          this.seriesF = res.data;
        })
        .catch(err => console.log(err));
    },
    fetchSeriesH() {
      fetch("/api/hommesU/" + this.user.id)
        .then(res => res.json())
        .then(res => {
          this.seriesH = res.data;
        })
        .catch(err => console.log(err));
    },
    fetchSeriesE() {
      fetch("/api/enfantsU/" + this.user.id)
        .then(res => res.json())
        .then(res => {
          this.seriesE = res.data;
        })
        .catch(err => console.log(err));
    }
  },
  computed: {
    filtredF: function() {
      let currentObject = this;
      return this.seriesF.filter(function(item) {
        return (
          item.couleur.includes(currentObject.couleurFemme) &&
          item.ref.toString().includes(currentObject.refFemme.toString()) &&
          item.fournisseur.nom_marque.includes(currentObject.marqueFemme) &&
          item.typeSerie.libele.includes(currentObject.type_femme) &&
          item.articles.find(function(article) {
            return article.taille
              .toString()
              .includes(currentObject.tailleFemme.toString());
          })
        );
      });
    },
    filtredH: function() {
      let currentObject = this;
      return this.seriesH.filter(function(item) {
        return (
          item.couleur.includes(currentObject.couleurHomme) &&
          item.ref.toString().includes(currentObject.refHomme.toString()) &&
          item.fournisseur.nom_marque.includes(currentObject.marqueHomme) &&
          item.typeSerie.libele.includes(currentObject.type_homme) &&
          item.articles.find(function(article) {
            return article.taille
              .toString()
              .includes(currentObject.tailleHomme.toString());
          })
        );
      });
    },
    filtredE: function() {
      let currentObject = this;
      return this.seriesE.filter(function(item) {
        return (
          item.couleur.includes(currentObject.couleurEnfant) &&
          item.ref.toString().includes(currentObject.refEnfant.toString()) &&
          item.fournisseur.nom_marque.includes(currentObject.marqueEnfant) &&
          item.typeSerie.libele.includes(currentObject.type_enfant) &&
          item.articles.find(function(article) {
            return article.taille
              .toString()
              .includes(currentObject.tailleEnfant.toString());
          })
        );
      });
    },
    paginedF() {
      return this.filtredF.slice(
        this.pageF * this.itemsPerPageF,
        this.itemsPerPageF * this.pageF + this.itemsPerPageF
      );
    },
    paginedH() {
      return this.filtredH.slice(
        this.pageH * this.itemsPerPageH,
        this.itemsPerPageH * this.pageH + this.itemsPerPageH
      );
    },
    paginedE() {
      return this.filtredE.slice(
        this.pageE * this.itemsPerPageE,
        this.itemsPerPageE * this.pageE + this.itemsPerPageE
      );
    }
  }
};
</script>