 <template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-33">
        <div class="card" style="width: 18rem;">
          <img class="card-img-top" src="/photos/NoImage.png" alt="Card image cap" style="height: 10rem;"/>
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p
              class="card-text"
            >Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>
        <!-- <chart-card :key="componentKey"
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
        </chart-card>-->
      </div>
    </div>
  </div>
</template>
<!--<script>
import { ChartCard } from "@/components";
import { METHODS } from "http";

export default {
  components: {
    ChartCard
  },
  data() {
    return {
      componentKey:0,
      charges: [],
      dates: [],
      montants: [],
      emailsSubscriptionChart: {
        data: {
          labels: [
            "Ja",
            "Fe",
            "Ma",
            "Ap",
            "Mai",
            "Ju",
            "Jul",
            "Au",
            "Se",
            "Oc",
            "No",
            "De"
          ],
          series: [[542, 443, 320, 780, 553, 453, 326, 434, 568, 610, 756, 895]]
        },
        options: {
          axisX: {
            showGrid: false
          },
          low: 0,
          high: 10000,
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
              seriesBarDistance: 5,
              axisX: {
                labelInterpolationFnc: function(value) {
                  return value[0];
                }
              }
            }
          ]
        ]
      }
    };
  },
   created() {
    this.fetchCharges();
  },
  methods: {
     forceRerender() {
      this.componentKey += 1;
    },
    fetchCharges() {
      fetch("/api/charges")
        .then(res => res.json())
        .then(res => {
          //affecter res.data a articles
          this.charges = res.data; 
          var i;
          for(i=0;i<this.charges.length;i++)
          {
            this.dates.push(this.charges[i].date);
            this.montants.push(this.charges[i].montant_total);
           
          }
           this.emailsSubscriptionChart.data.labels=this.dates;
           this.emailsSubscriptionChart.data.series[0]=this.montants;
           this.forceRerender();

          console.log(this.dates);
        })
        .catch(err => console.log(err));
    }
  }
};
</script>-->

 
 