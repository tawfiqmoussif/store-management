<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item">
        <md-card>
          <!--<md-card-header data-background-color="green">
            <h4 class="title"></h4>
            <p class="category"></p>
          </md-card-header>-->
          <md-card-content>
            <md-table v-model="avances" table-header-color="green" :key="n">
              <md-table-row slot="md-table-row" slot-scope="{ item }" style="direction: ltr !important;">
                <md-table-cell md-label="  ">{{ item[0] }}</md-table-cell>
                <md-table-cell md-label="1"><p> <span v-html="item[1]"></span></p></md-table-cell>
                <md-table-cell md-label="2"><p> <span v-html="item[2]"></span></p></md-table-cell>
                <md-table-cell md-label="3"><p> <span v-html="item[3]"></span></p></md-table-cell>
                <md-table-cell md-label="4"><p> <span v-html="item[4]"></span></p></md-table-cell>
                <md-table-cell md-label="5"><p> <span v-html="item[5]"></span></p></md-table-cell>
                <md-table-cell md-label="6"><p> <span v-html="item[6]"></span></p></md-table-cell>
                <md-table-cell md-label="7"><p> <span v-html="item[7]"></span></p></md-table-cell>
                <md-table-cell md-label="8"><p> <span v-html="item[8]"></span></p></md-table-cell>
                <md-table-cell md-label="9"><p> <span v-html="item[9]"></span></p></md-table-cell>
                <md-table-cell md-label="10"><p> <span v-html="item[10]"></span></p></md-table-cell>
                <md-table-cell md-label="11"><p> <span v-html="item[11]"></span></p></md-table-cell>
                <md-table-cell md-label="12"><p> <span v-html="item[12]"></span></p></md-table-cell>
              </md-table-row>
            </md-table>
          </md-card-content>
        </md-card>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      token: localStorage.getItem("token"),
      avances: [],
      n: 0
    };
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
    forceRerender() {
      this.n += 1;
    }
  },
  created() {
    var i, j;
    for (i = 0; i < 6; i++) {
      this.avances[i] = new Array();
      this.avances[0][0] = 5;
      for (j = 0; j < 12; j++) {
        if (j == 0 && i > 0) {
          this.avances[i][j] = this.avances[i - 1][j] + 5;
        }
        this.avances[i].push("");
      }
    }
    let date = { date: this.formatDate(new Date()) };
    fetch("api/avancesEntreeCalendar?token=" + this.token, {
      method: "post",
      body: JSON.stringify({ date: date }),
      headers: {
        "content-type": "application/json"
      }
    })
      .then(res => res.json())
      .then(data => {
        var j;
        for (j = 0; j < data.data.length; j++) {
          var date = data.data[j].date.split("-"); //annee - mois - jour
          this.avances[Number(date[2]) / 5 - 1][Number(date[1])] =
            this.avances[Number(date[2]) / 5 - 1][Number(date[1])] +
            "<br>" +
            data.data[j].entree.fournisseur.personne.nom +
            " " +
            data.data[j].entree.fournisseur.personne.prenom  +' '+ data.data[j].montant+' DH '+"<label style='color: red;'> " + data.data[j].numero.slice(-3)+'</label> ' +' '+ data.data[j].type_paiement;
           
          //console.log(this.avances[Number(date[2]) / 5 - 1][Number(date[1])]);
          //console.log(date);
        }
        this.forceRerender();
      })
      .catch(err => console.log(err));
  }
};
</script>