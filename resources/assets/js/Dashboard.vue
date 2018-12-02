<template>
  <v-app id="keep">
    <v-navigation-drawer
      v-model="drawer"
      fixed
      clipped
      class="grey lighten-4"
      app
    >
      <v-list
        dense
        class="grey lighten-4 mt-3"
      >
        <template v-for="(item, i) in menuItems">
          <v-layout
            v-if="item.heading"
            :key="i"
            row
            align-center
          >
            <v-flex xs6>
              <v-subheader v-if="item.heading">
                {{ item.heading }}
              </v-subheader>
            </v-flex>
          </v-layout>
          <v-divider
            v-else-if="item.divider"
            :key="i"
            dark
            class="my-3"
          ></v-divider>
          <v-list-tile
            v-else
            :key="i"
            @click="$router.push(item.link)"
          >
            <v-list-tile-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title class="grey--text">
                {{ item.text }}
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </template>
      </v-list>
    </v-navigation-drawer>
    <v-toolbar color="blue darken-4" dark app absolute clipped-left>
      <v-toolbar-side-icon @click.native="drawer = !drawer"></v-toolbar-side-icon>
      <span class="title ml-3 mr-5">BILD&nbsp;<span class="font-weight-light">Lethbridge</span></span>
      <v-spacer></v-spacer>
    </v-toolbar>
    <v-content>
      <!-- For showing user alerts and feedback -->
      <v-snackbar
        v-model="snackbar"
        :timeout="timeout"
        :absolute="true"
        :multi-line="true"
        class="absolute-center"
      >
        {{ snackBarText }}
        <v-btn flat class="pink--text" @click.native.stop="snackbar = false">Close</v-btn>
      </v-snackbar>

      <v-container fluid fill-height>

        <router-view></router-view>

      </v-container>
    </v-content>
    <v-footer color="blue darken-4" class="white--text" app>
      <span class="ml-2">BILD</span>
      <v-spacer></v-spacer>
      <span class="mr-2">&copy; 2018</span>
    </v-footer>
  </v-app>
</template>

<script>
  export default {
    data: function(){
      return {
        snackbar: false,
        mode: '',
        timeout: 10000,
        snackBarText: '',
        drawer: null,
        menuItems: [
          { icon: 'dashboard', text: 'Dashboard', link: '/' },
          { divider: true }
        ],
        token: window.Laravel.csrfToken,
        authEmail: AUTH_EMAIL
      }
    },
    props: {
      source: String
    },
    components: {
    },
    methods: {
    },
    created () {
      this.$router.app.$on('snackbar', (config) => {
        this.snackbar = true;
        this.snackBarText = config.text;
      });
    }
  }
</script>

<style scoped>
  .absolute-center{
    top: 40%;
  }
</style>
