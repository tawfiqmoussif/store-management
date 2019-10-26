<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-size-66" >
        <form @submit.prevent="updateClient" enctype="multipart/form-data">
          <md-card>
            <md-card-header data-background-color="green">
              <h4 style="font-weight: regular;" class="title">الزبناء</h4>
              <p style="font-size:20px;font-weight: bold;" class="category">تعديل الزبناء</p>
            </md-card-header>

            <md-card-content>
              <div class="md-layout">
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field>
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">الاسم الشخصي</label>
                    <md-input type="text" v-model="client.personne.prenom"></md-input>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field>
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">الاسم العائلي</label>
                    <md-input type="text" v-model="client.personne.nom"></md-input>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field>
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">رقم الهاتف</label>
                    <md-input type="tel" v-model="client.personne.tel"></md-input>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-65">
                  <md-field>
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">العنوان</label>
                    <md-input type="text" v-model="client.personne.adresse"></md-input>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field>
                    <label style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;">الرقم الضريبي</label>
                    <md-input type="text" v-model="client.identification_fiscale"></md-input>
                  </md-field>
                </div>


                <div class="md-layout-item md-size-100 text-right">
                  <md-button type="submit" style="font-family: 'Droid Arabic Naskh', serif;font-weight: regular;" class="md-raised md-success">تعديل</md-button>
                </div>
              </div>
            </md-card-content>
          </md-card>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    props: {
      dataBackgroundColor: {
        type: String,
        default: ""
      }
    },
    data() {
      return {
        //personne: new Object(),
        client: new Object(),
        clientT: {
          identification_fiscale: "",
          personne_id: ""
        }
      };
    },
    created() {
      this.client = this.$route.params.client;
    },
    methods: {
      updateClient() {
        this.clientT = new Object();
        this.clientT.identification_fiscale = this.client.identification_fiscale;
        fetch(`api/personne/${this.client.personne.id}`, {
          method: "put",
          body: JSON.stringify(this.client.personne),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {
            alert("Personne Added");
            this.client.personne_id = data.data.id;
            fetch(`api/client/${this.client.id}`, {
              method: "put",
              body: JSON.stringify(this.client),
              headers: {
                "content-type": "application/json"
              }
            })
              .then(res => res.json())
              .then(data => {
                alert("Client Added");
                this.$router.push({ name: 'ListeClients' });
              })
              .catch(err => console.log(err));
          })
          .catch(err => console.log(err));


      }
    }
  };
</script>


<style>
</style>