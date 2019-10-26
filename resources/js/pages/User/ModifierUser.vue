<template>
  <div class="content">
    <div class="md-layout">
      <div class="md-layout-item md-medium-size-100 md-size-66">
        <form @submit.prevent="updateUser" enctype="multipart/form-data">
          <md-card>
            <md-card-header data-background-color="green">
              <h4 class="title">المستعملين</h4>
              <p class="category">تعديل المستعملين</p>
            </md-card-header>

            <md-card-content>
              <div class="md-layout">
                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field>
                    <label>الاسم الشخصي</label>
                    <md-input type="text" v-model="user.personne.prenom"></md-input>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field>
                    <label>الاسم العائلي</label>
                    <md-input type="text" v-model="user.personne.nom"></md-input>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field>
                    <label>رقم الهاتف</label>
                    <md-input type="tel" v-model="user.personne.tel"></md-input>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-65">
                  <md-field>
                    <label>العنوان</label>
                    <md-input type="text" v-model="user.personne.adresse"></md-input>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field>
                    <label>اسم المستعمل</label>
                    <md-input type="text" v-model="user.name"></md-input>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field>
                    <label>الإيميل</label>
                    <md-input type="text" v-model="user.email"></md-input>
                  </md-field>
                </div>

                <div class="md-layout-item md-small-size-100 md-size-50">
                  <md-field>
                    <label>كلمة السر</label>
                    <md-input type="text" v-model="user.password"></md-input>
                  </md-field>
                </div>


                <div class="md-layout-item md-size-100 text-right">
                  <md-button type="submit" class="md-raised md-success">تعديل</md-button>
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
        user: new Object(),
        userT: {
          name: "",
          email: "",
          password: "",
          personne_id: ""
        }
      };
    },
    created() {
      this.user = this.$route.params.user;
    },
    methods: {
      updateUser() {
        this.userT = new Object();
        this.userT.name = this.user.name;
        this.userT.email = this.user.email;
        this.userT.password = this.user.password;
        fetch(`api/personne/${this.user.personne.id}`, {
          method: "put",
          body: JSON.stringify(this.user.personne),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {
            alert("Personne Added");
            this.user.personne_id = data.data.id;
            fetch(`api/user/${this.user.id}`, {
              method: "put",
              body: JSON.stringify(this.user),
              headers: {
                "content-type": "application/json"
              }
            })
              .then(res => res.json())
              .then(data => {
                alert("User Added");
                this.$router.push({ name: 'ListeUsers' });
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