<template>
  <div class="content">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <div class="md-layout">
      <!--<md-button class="md-success" to="/ajouterSerie">إضافة سيري</md-button>-->

      <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
        <md-card>
          <md-card-header data-background-color="green">
            <h4 class="title">قائمة الأحذية</h4>
            <p class="category"></p>
          </md-card-header>
          <md-card-content>
            <md-table v-model="articles" table-header-color="green">
              <md-table-row slot="md-table-row" slot-scope="{ item }">
                <md-table-cell md-label="رقم الحذاء">{{ item.taille }}</md-table-cell>
                <md-table-cell md-label="المخزون">{{ item.stock }}</md-table-cell>
                <md-table-cell md-label="ثمن الشراء">{{prix_achat}}</md-table-cell>
                <md-table-cell md-label="ثمن البيع">{{prix_de_vente}}</md-table-cell>
                <md-table-cell md-label="اختيار">
                  <md-button
                    class="md-warning md-just-icon md-round"
                    @click.native="lancerModal(item)"
                  >
                    <md-icon>edit</md-icon>
                  </md-button>
                  <md-button
                    class="md-primary md-just-icon md-round"
                    style="font-size: 16px;"
                    type="button"
                    :data-toggle="modal2"
                    data-target="#exampleModal"
                     @click="lancerModal2(item)"
                  >
                    <md-icon>shopping_cart</md-icon>
                  </md-button>
                </md-table-cell>
              </md-table-row>
            </md-table>
            <mdb-modal :show="modal" @close="modal = false">
              <mdb-modal-header>
                <mdb-modal-title>تعديل المخزون</mdb-modal-title>
              </mdb-modal-header>
              <mdb-modal-body>
                <input
                  class="form-control form-control-lg"
                  disabled
                  v-model="article.taille"
                  type="text"
                  placeholder="رقم الحداء"
                />
              </mdb-modal-body>
              <mdb-modal-body>
                <input
                  class="form-control form-control-lg"
                  v-model="article.stock"
                  type="text"
                  placeholder="المخزون"
                />
              </mdb-modal-body>
              <mdb-modal-footer>
                <mdb-btn @click="updateArticle()" color="primary">حفظ التغييرات</mdb-btn>
                <mdb-btn color="secondary" style="margin :10px;" @click.native="modal = false">إغلاق</mdb-btn>
              </mdb-modal-footer>
            </mdb-modal>
          </md-card-content>
        </md-card>
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
                <md-field>
                  <label>ثمن البيع</label>
                  <md-input type="text" v-model="sortie_details.prix_de_vente_2"></md-input>
                </md-field>
                <md-field>
                  <label>تاريخ البيع</label>
                  <md-input type="date" v-model="sortie_details.date"></md-input>
                </md-field>
                <md-field>
                  <label>عدد المبيعات</label>
                  <md-input type="text" v-model="sortie_details.nombre"></md-input>
                </md-field>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  data-dismiss="modal"
                  class="btn btn-success"
                  @click="addSortie()"
                  style="margin-top : -15px;border-color: #4caf50;background-color: #4caf50 !important;"
                >اضافة</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">خروج</button>
              </div>
            </div>
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
  name: "liste-series",
  props: {
    tableHeaderColor: {
      type: String,
      default: ""
    }
  },
  data() {
    return {
      articles: new Object(),
      sorties: [],
      modal: false,
      idSerie: "",
      taille: "",
      stock: "",
      article: {
        id: "",
        taille: "",
        stock: "",
        idSerie: ""
      },
      sortie_details: {
        article_id: "",
        prix_de_vente_1: "",
        prix_de_vente_2: "",
        nombre: "",
        date: this.formatDate(new Date())
      },
      modal2: "modal",
      prix_achat: 0,
      prix_de_vente: 0,
      token: localStorage.getItem("token")
    };
  },
  created() {
    this.articles = this.$route.params.serie.articles;
    this.returnPrix(this.$route.params.serie.id);
  },
  methods: {
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
    fetchArticles() {
      fetch(`api/articles/${this.$route.params.serie.id}`)
        .then(res => res.json())
        .then(res => {
        this.articles= res.data;
        })
        .catch(err => console.log(err));
    },
    returnPrix(id) {
      fetch(`api/returnPrix/${id}`)
        .then(res => res.json())
        .then(res => {
          this.prix_achat = res.prix_achat;
          this.prix_de_vente = res.prix_de_vente;
          this.sortie_details.prix_de_vente_1 = res.prix_de_vente;
          this.sortie_details.prix_de_vente_2 = res.prix_de_vente;
        })
        .catch(err => console.log(err));
    },
    fetchSortiesDetails() {
      fetch("/api/sortieDetails")
        .then(res => res.json())
        .then(res => {
          this.sorties = res.data;
          //console.log(this.sorties);
        })
        .catch(err => console.log(err));
    },
    lancerModal(item) {
      this.article.id = item.id;
      this.article.idSerie = this.idSerie;
      this.article.taille = item.taille;
      this.article.stock = item.stock;
      this.modal = true;
    },
     lancerModal2(item) {
      this.sortie_details.article_id = item.id;
    },
    updateArticle() {
      fetch(`api/article/${this.article.id}`, {
        method: "put",
        body: JSON.stringify(this.article),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(res => {
          this.fetchArticles();
          this.modal = false;
        })
        .catch(err => console.log(err));
    },
    addSortie() {
      fetch("api/sortieDetails?token=" + this.token, {
        method: "post",
        body: JSON.stringify(this.sortie_details),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(res => {
          this.fetchArticles();
        })
        .catch(err => console.log(err));
    }
  }
};
</script>