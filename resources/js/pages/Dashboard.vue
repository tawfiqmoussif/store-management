<template>
  <div class="content">
    <div class="md-layout">
     <!-- <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-33">
        <chart-card
          :chart-data="dailySalesChart.data"
          :chart-options="dailySalesChart.options"
          :chart-type="'Line'"
          data-background-color="blue"
        >
          <template slot="content">
            <h4 class="title">Daily Sales</h4>
            <p class="category">
              <span class="text-success">
                <i class="fas fa-long-arrow-alt-up"></i> 55%
              </span> increase in today sales.
            </p>
          </template>

          <template slot="footer">
            <div class="stats">
              <md-icon>access_time</md-icon>updated 4 minutes ago
            </div>
          </template>
        </chart-card>
      </div>
      <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-33">
        <chart-card
          :chart-data="emailsSubscriptionChart.data"
          :chart-options="emailsSubscriptionChart.options"
          :chart-responsive-options="emailsSubscriptionChart.responsiveOptions"
          :chart-type="'Bar'"
          data-background-color="red"
        >
          <template slot="content">
            <h4 class="title">Email Subscription</h4>
            <p class="category">Last Campaign Performance</p>
          </template>

          <template slot="footer">
            <div class="stats">
              <md-icon>access_time</md-icon>updated 10 days ago
            </div>
          </template>
        </chart-card>
      </div>
      <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-33">
        <chart-card
          :chart-data="dataCompletedTasksChart.data"
          :chart-options="dataCompletedTasksChart.options"
          :chart-type="'Line'"
          data-background-color="green"
        >
          <template slot="content">
            <h4 class="title">Completed Tasks</h4>
            <p class="category">Last Campaign Performance</p>
          </template>

          <template slot="footer">
            <div class="stats">
              <md-icon>access_time</md-icon>campaign sent 26 minutes ago
            </div>
          </template>
        </chart-card>
      </div>-->
     <!-- <div class="md-layout-item md-medium-size-50 md-xsmall-size-100 md-size-25">
        <stats-card data-background-color="green">
          <template slot="header">
            <md-icon>store</md-icon>
          </template>

          <template slot="content">
            <p class="category">Revenue</p>
            <h3 class="title">$34,245</h3>
          </template>

          <template slot="footer">
            <div class="stats">
              <md-icon>date_range</md-icon>Last 24 Hours
            </div>
          </template>
        </stats-card>
      </div>
      <div class="md-layout-item md-medium-size-50 md-xsmall-size-100 md-size-25">
        <stats-card data-background-color="orange">
          <template slot="header">
            <md-icon>content_copy</md-icon>
          </template>

          <template slot="content">
            <p class="category">Used Space</p>
            <h3 class="title">
              49/50
              <small>GB</small>
            </h3>
          </template>

          <template slot="footer">
            <div class="stats">
              <md-icon class="text-danger">warning</md-icon>
              <a href="#pablo">Get More Space...</a>
            </div>
          </template>
        </stats-card>
      </div>
      <div class="md-layout-item md-medium-size-50 md-xsmall-size-100 md-size-25">
        <stats-card data-background-color="red">
          <template slot="header">
            <md-icon>info_outline</md-icon>
          </template>

          <template slot="content">
            <p class="category">Fixed Issues</p>
            <h3 class="title">75</h3>
          </template>

          <template slot="footer">
            <div class="stats">
              <md-icon>local_offer</md-icon>Tracked from Github
            </div>
          </template>
        </stats-card>
      </div>
      <div class="md-layout-item md-medium-size-50 md-xsmall-size-100 md-size-25">
        <stats-card data-background-color="blue">
          <template slot="header">
            <i class="fab fa-twitter"></i>
          </template>

          <template slot="content">
            <p class="category">Folowers</p>
            <h3 class="title">+245</h3>
          </template>

          <template slot="footer">
            <div class="stats">
              <md-icon>update</md-icon>Just Updated
            </div>
          </template>
        </stats-card>
      </div>
      -->
      <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
        <chart-card :key="componentKey"
          :chart-data="evolution.data"
          :chart-options="evolution.options"
          :chart-responsive-options="evolution.responsiveOptions"
          :chart-type="'Bar'"
          data-background-color="green"
        >
          <template slot="content">
            <h4 class="title">الأرباح</h4>
          </template>

          <template slot="footer">
            <div class="stats">
             <!-- <md-icon>access_time</md-icon>updated 10 days ago-->
            </div>
          </template>
        </chart-card>
        </div>
      <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100" v-if="user.role === '1'">
        <div class="md-layout-item md-small-size-100 md-size-33">
          <md-field>
            <label>صاحب المحل</label>
             <md-select v-model="selected">
                      <md-option
                        v-for="user in users"
                        :key="user.id"
                        :value="user.id"
                      >{{user.personne.nom}} {{user.personne.prenom}}</md-option>
                    </md-select>
          </md-field>
        </div>
        <md-card>
          <md-card-header data-background-color="orange">
            <h4 class="title">المبيعات اليومية للمحلات</h4>
          </md-card-header>
          <md-card-content>
            <md-table table-header-color="orange">
                <md-table table-header-color="green" v-model="sortieDetails">
          <md-table-row slot="md-table-row" slot-scope="{ item }">
            <md-table-cell md-label="نوع البضاعة">{{item.article.serie.ref}}</md-table-cell>
            <md-table-cell md-label="اللون">{{item.article.serie.couleur}}</md-table-cell>
            <md-table-cell md-label="الصنف">{{item.article.serie.genre}}</md-table-cell>
            <md-table-cell md-label="المورد">{{item.article.serie.personne.nom}} {{item.article.serie.personne.prenom}}</md-table-cell>
            <md-table-cell md-label="رقم الحذاء">{{item.article.taille}}</md-table-cell>
            <md-table-cell md-label="الثمن المحدد">{{ item.prix_de_vente_1}}</md-table-cell>
            <md-table-cell md-label="ثمن البيع">{{ item.prix_de_vente_2}}</md-table-cell>
            <md-table-cell md-label="العدد">{{ item.nombre}}</md-table-cell>
          </md-table-row>
        </md-table>
            </md-table>
          </md-card-content>
        </md-card>
      </div>
      <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-50">
        <chart-card :key="componentKey"
          :chart-data="electricite.data"
          :chart-options="electricite.options"
          :chart-responsive-options="electricite.responsiveOptions"
          :chart-type="'Bar'"
          data-background-color="orange"
        >
          <template slot="content">
            <h4 class="title">استهلاك الكهرباء</h4>
          </template>

          <template slot="footer">
            <div class="stats">
              <md-icon>access_time</md-icon>updated 10 days ago
            </div>
          </template>
        </chart-card>
        </div>
         <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-50">
        <chart-card :key="componentKey"
          :chart-data="eau.data"
          :chart-options="eau.options"
          :chart-responsive-options="eau.responsiveOptions"
          :chart-type="'Bar'"
          data-background-color="blue"
        >
          <template slot="content">
            <h4 class="title">استهلاك الماء</h4>
          </template>

          <template slot="footer">
            <div class="stats">
              <md-icon>access_time</md-icon>updated 10 days ago
            </div>
          </template>
        </chart-card>
        </div>
      <!--<div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-50">
        <nav-tabs-card>
          <template slot="content">
            <span class="md-nav-tabs-title">Tasks:</span>
            <md-tabs md-sync-route class="md-success" md-alignment="left">
              <md-tab id="tab-home" md-label="Bugs" md-icon="bug_report">
                <nav-tabs-table></nav-tabs-table>
              </md-tab>

              <md-tab id="tab-pages" md-label="Website" md-icon="code">
                <nav-tabs-table></nav-tabs-table>
              </md-tab>

              <md-tab id="tab-posts" md-label="server" md-icon="cloud">
                <nav-tabs-table></nav-tabs-table>
              </md-tab>
            </md-tabs>
          </template>
        </nav-tabs-card>
      </div>-->
    </div>
  </div>
</template>

<script>
import {
  StatsCard,
  ChartCard,
  NavTabsCard,
  NavTabsTable,
  OrderedTable
} from "@/components";

export default {
  components: {
    StatsCard,
    ChartCard,
    NavTabsCard,
    NavTabsTable,
    OrderedTable
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
    dailyStatistics() {
      let date = this.formatDate(new Date());
      fetch("api/dailyStatistics?token=" + this.token, {
        method: "post",
        body: JSON.stringify({ date: date }),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(res => {
          console.log(res);
        })
        .catch(err => console.log(err));
    },
     forceRerender() {
      this.componentKey += 1;
    },
    ///////////////////////////////////////
    fetchCharges1() {
      fetch("/api/electricite?token=" + this.token)
        .then(res => res.json())
        .then(res => {
          //affecter res.data a articles
          this.charges1 = res.data; 
          var i;
          var max=0;
          //var marge=100;
          for(i=(this.charges1.length-1);i>=0;i--)
          {
            this.dates1.push(this.charges1[i].date);
            this.montants1.push(this.charges1[i].montant_total);
           if(max<this.charges1[i].montant_total){
              max=this.charges1[i].montant_total;
            }
           
          }
         var marge=(max/2);
         console.log(marge);
         
          max=max+Number(marge);
           this.electricite.data.labels=this.dates1;
           this.electricite.data.series[0]=this.montants1;
           this.forceRerender();
           this.electricite.options.high=max;
        })
        .catch(err => console.log(err));
    },
    /////////////////////////////////////////////////////////////////////////
    fetchCharges2() {
      fetch("/api/eau?token=" + this.token)
        .then(res => res.json())
        .then(res => {
          //affecter res.data a articles
          this.charges2 = res.data; 
          var i;
          var max=0;
          //var marge=100;
          for(i=(this.charges2.length-1);i>=0;i--)
          {
            this.dates2.push(this.charges2[i].date);
            this.montants2.push(this.charges2[i].montant_total);
            if(max<this.charges2[i].montant_total){
              max=this.charges2[i].montant_total;
            }
           
          }
          var marge=(max/2);
           max=max+Number(marge);
           this.eau.data.labels=this.dates2;
           this.eau.data.series[0]=this.montants2;
           this.forceRerender();
           this.eau.options.high=max;
         
        })
        .catch(err => console.log(err));
    },
    ////////////////////////////////////////////////////////////////
    statistics() {
      let data = {
         date: this.formatDate(new Date())
       };
       fetch("api/statistics?token=" + this.token, {
        method: "post",
        body: JSON.stringify(data),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(res => {
          var tab = res.benifices;
          this.evolution.data.series[0][0] = tab['01'];
          this.evolution.data.series[0][1] = tab['02'];
          this.evolution.data.series[0][2] = tab['03'];
          this.evolution.data.series[0][3] = tab['04'];
          this.evolution.data.series[0][4] = tab['05'];
          this.evolution.data.series[0][5] = tab['06'];
          this.evolution.data.series[0][6] = tab['07'];
          this.evolution.data.series[0][7] = tab['08'];
          this.evolution.data.series[0][8] = tab['09'];
          this.evolution.data.series[0][9] = tab['10'];
          this.evolution.data.series[0][10] = tab['11'];
          this.evolution.data.series[0][11] = tab['12'];
          this.forceRerender();
            //affecter res.data a articles
        /*  var ev = res; 
          
          var max=0;
          var marge=50;
          for(i=(this.charges2.length-1);i>=0;i--)
          {
            this.dates2.push(this.charges2[i].date);
            this.montants2.push(this.charges2[i].montant_total);
            if(max<this.charges2[i].montant_total){
              max=this.charges2[i].montant_total;
            }
           
          }
           max=max+Number(marge);
           this.eau.data.labels=this.dates2;
           this.eau.data.series[0]=this.montants2;
           this.forceRerender();
           this.eau.options.high=max;*/
        })
        .catch(err => console.log(err));
    },
    fetchSortiesDetails() {
      let data = {
         date: this.formatDate(new Date()),
         user_id: this.selected
       };
       fetch("api/dailySales", {
        method: "post",
        body: JSON.stringify(data),
        headers: {
          "content-type": "application/json"
        }
      })
        .then(res => res.json())
        .then(res => {
          this.sortieDetails = res.data;
        })
        .catch(err => console.log(err));
    },
     fetchUsers() {
       fetch("/api/users")
        .then(res => res.json())
        .then(res => {
          this.users = res.data;
        })
        .catch(err => console.log(err));
    }
  },
  created() {
    this.dailyStatistics();
    this.fetchUsers();
    this.fetchSortiesDetails();
    this.fetchCharges1();
    this.fetchCharges2();
    this.statistics();
     fetch("/api/returnUser?token=" + this.token)
      .then(res => res.json())
      .then(res => {
        this.user = res.data;
      })
      .catch(err => console.log(err));
  },
  data() {
    return {
    
     
      token: localStorage.getItem("token"),
      users: [],
      user: new Object(),
      selected: 1,
      sortieDetails: [],
      //added by chakib
       componentKey:0,
      charges1: [],
      charges2: [],
      dates1: [],
      dates2: [],
      montants1: [],
      montants2: [],
      ////////////////////////////////////////////////////////
      electricite: {
        data: {
          labels: [],
          series: [[]]
        },
        options: {
          axisX: {
            showGrid: false
          },
          low: 0,
          high: "",
          chartPadding: {
            top: 0,
            right: 5,
            bottom: 0,
            left: 0
          }
        },
        responsiveOptions: [
          [
            "screen and (max-width: 640px)",
            {
              seriesBarDistance: 12,
              axisX: {
                labelInterpolationFnc: function(value) {
                  return value[0];
                }
              }
            }
          ]
        ]
      },
////////////////////////////////////////////////////////////
      eau: {
        data: {
          labels: [],
          series: [[]]
        },
        options: {
          axisX: {
            showGrid: false
          },
          low: 0,
          high: "",
          chartPadding: {
            top: 0,
            right: 5,
            bottom: 0,
            left: 0
          }
        },
        responsiveOptions: [
          [
            "screen and (max-width: 640px)",
            {
              seriesBarDistance: 12,
              axisX: {
                labelInterpolationFnc: function(value) {
                  return value[0];
                }
              }
            }
          ]
        ]
      },
      /////////////////////////////
      ////////////////////////////////////////////////////////////
      evolution: {
        data: {
          labels: ['يناير', 'فبراير', 'مارس', 'ابريل', 'ماي', 'يونيو', 'يوليوز', 'غشت', 'شتنبر', 'اكتوبر', 'نونبر', 'دجنبر'],
          series: [[]]
        },
        options: {
          axisX: {
            showGrid: false
          },
          low: 0,
          high: "500000",
          chartPadding: {
            top: 0,
            right: 5,
            bottom: 0,
            left: 0
          }
        },
        responsiveOptions: [
          [
            "screen and (max-width: 640px)",
            {
              seriesBarDistance: 12,
              axisX: {
                labelInterpolationFnc: function(value) {
                  return value[0];
                }
              }
            }
          ]
        ]
      }
      /////////////////////////////
    };
  },
  watch: {
    selected: function (val) {
     this.fetchSortiesDetails();
    },
  }
};
</script>
