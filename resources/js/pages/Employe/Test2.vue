<template>
  <div class="content" style="direction: ltr !important; ">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-size-160">
        <div class="md-layout-item md-small-size-100 md-size-33">
          <md-field>
            <label>نوع البضاعة</label>
            <md-select v-model="selected">
              <md-option
                v-for="serie in series"
                :key="serie.id"
                :value="serie.id"
              >{{serie.ref}} {{serie.couleur}}</md-option>
            </md-select>
          </md-field>
        </div>
         <div class="md-layout-item md-small-size-100 md-size-100">
                <mdb-tbl bordered>
                  <mdb-tbl-head color="light">
                    <tr>
                      <th scope="col" v-for="article in articles" :key="article.id">{{article.taille}}</th>
                    </tr>
                  </mdb-tbl-head>
                  <mdb-tbl-body>
                    <tr>
                      <td v-for="article in articles" :key="article.id">
                        <label contenteditable="true">Example Label</label>
                      </td>
                    </tr>
                  </mdb-tbl-body>
                </mdb-tbl>
              </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mdbTbl, mdbTblHead, mdbTblBody, mdbScrollbar } from "mdbvue";
export default {
  name: "TableScrollPage",
  data() {
    return {
      series: null,
      selected: "",
      articles: new Object(),
    };
  },
  created() {
    this.fetchSeries();
  },
  components: {
    mdbTbl,
    mdbTblHead,
    mdbTblBody,
    mdbScrollbar
  },
  methods: {
    fetchSeries() {
      fetch("/api/series")
        .then(res => res.json())
        .then(res => {
          //affecter res.data a series
          this.series = res.data;
          console.log(this.series);
        })
        .catch(err => console.log(err));
    },
   onChange() {
            console.log('The new value is: ', this.selected)
        }
  },
  watch: {
    selected: function(event) {
       fetch(`api/returnTailles/${this.selected}`)
        .then(res => res.json())
        .then(res => {
         this.articles=res.data;
        })
        .catch(err => console.log(err));
    }
  }
};
</script>
   
 