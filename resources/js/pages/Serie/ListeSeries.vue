<template>
  <div class="content" style="direction: ltr !important; ">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-size-160">
        <md-button class="md-success md-just-icon md-round" to="/ajouterSerie">
          <md-icon>add</md-icon>
        </md-button>
      
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
                  <md-button  :to="{name: 'ModifierSerie',params: {serie: serieF}}" class="md-warning md-just-icon md-round">
                    <md-icon>edit</md-icon>
                  </md-button>
                  <md-button class="md-danger md-just-icon md-round">
                    <md-icon>delete</md-icon>
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
              <p v-if="this.filtredF.length>0"
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
                  <md-button  :to="{name: 'ModifierSerie',params: {serie: serieH}}" class="md-warning md-just-icon md-round">
                    <md-icon>edit</md-icon>
                  </md-button>
                  <!--<md-button class="md-danger md-just-icon md-round">
                    <md-icon>delete</md-icon>
                  </md-button>-->
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
              <p v-if="this.filtredH.length>0"
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
                  <md-button  :to="{name: 'ModifierSerie',params: {serie: serieE}}" class="md-warning md-just-icon md-round">
                    <md-icon>edit</md-icon>
                  </md-button>
                 <!-- <md-button class="md-danger md-just-icon md-round">
                    <md-icon>delete</md-icon>
                  </md-button>-->
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
              <p v-if="this.filtredE.length>0"
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
      </div>
    </div>
  </div>
</template>

<script>
import {
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
  mdbCarouselItem
} from "mdbvue";

export default {
  name: "TabPage",
  components: {
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
    mdbCarouselItem,
    mdbCarousel
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
      itemsPerPageE: 3
    };
  },
  created() {
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
      this.$router.push({ name: "articles", params: { serie } });
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
      const token = localStorage.getItem("token");
      fetch("/api/femmes?token=" + token)
        .then(res => res.json())
        .then(res => {
          this.seriesF = res.data;
        })
        .catch(err => console.log(err));
    },
    fetchSeriesH() {
      const token = localStorage.getItem("token");
      fetch("/api/hommes?token=" + token)
        .then(res => res.json())
        .then(res => {
          this.seriesH = res.data;
        })
        .catch(err => console.log(err));
    },
    fetchSeriesE() {
      const token = localStorage.getItem("token");
      fetch("/api/enfants?token=" + token)
        .then(res => res.json())
        .then(res => {
          this.seriesE = res.data;
        })
        .catch(err => console.log(err));
    },
    destroySerie(idSerie) {
      if (confirm("Vous etes sur ?")) {
        fetch(`/api/serie/${idSerie}`, {
          method: "delete"
        })
          .then(res => res.json())
          .then(res => {
            alert("Serie removed");
          })
          .catch(err => console.log(err));
      }
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