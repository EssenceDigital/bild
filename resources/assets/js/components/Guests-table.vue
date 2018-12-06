<template>
 	<v-card class="elevation-0">
    <!-- Title -->
    <v-card-title>
      Guest RSVPs
      <v-spacer></v-spacer>
      <v-text-field
        append-icon="search"
        label="Search"
        single-line
        hide-details
        v-model="search"
      ></v-text-field>
    </v-card-title>

    <!-- Table -->
    <v-data-table
      :headers="headers"
      :items="guests"
      :search="search"
      :loading="loading"
    >
      <template slot="items" slot-scope="props">
        <tr>
          <td class="text-xs-left">{{ props.item.name }}</td>
          <td class="text-xs-left">{{ props.item.email }}</td>
          <td class="text-xs-left">
            <span v-if="props.item.rsvp == 'No'">
              <v-chip color="error" text-color="white">No</v-chip>
            </span>
            <span v-if="props.item.rsvp == 'Yes'">
              <v-chip color="success" text-color="white">Yes</v-chip>
            </span>
          </td>
          <td class="text-xs-left">{{ props.item.tickets }}</td>
          <td class="text-xs-left">{{ props.item.drink_tickets }}</td>
          <td class="text-xs-left">{{ props.item.dietary }}</td>
          <td class="text-xs-left">{{ props.item.additional }}</td>
          <td class="text-xs-right">
            <v-tooltip left>
              <v-btn
                slot="activator"
                flat
                @click="openDialog(props.item)"
              >
                <v-icon color="teal" >edit</v-icon>
              </v-btn>
              <span>Edit RSVP</span>
            </v-tooltip>
          </td>
        </tr>
      </template>
      <template slot="pageText" slot-scope="{ pageStart, pageStop }">
        From {{ pageStart }} to {{ pageStop }}
      </template>
    </v-data-table>

    <v-dialog v-model="editDialog" persistent max-width="650" persistent>
      <v-card>
        <v-card-title class="headline">
          Edit RSVP
          <v-spacer></v-spacer>
          <v-btn
            color="error darken-1"
            flat
            icon
            @click="closeDialog"
          >
          <v-icon>close</v-icon>
        </v-btn>
        </v-card-title>
        <v-card-text>
          <rsvp-form :rsvp="selectedGuest" @saved="saved"></rsvp-form>
        </v-card-text>
      </v-card>
    </v-dialog>

  </v-card>
</template>

<script>
  import axios from 'axios';
  import Helpers from './../app/helpers';
  import RsvpForm from './Edit-rsvp-form';

	export default{
		data (){
			return {
				search: '',
				loading: true,
        editDialog: false,
        guests: [],
        selectedGuest: {},
 				headers: [
          {
            text: 'Name',
            align: 'left',
            sortable: true,
            value: 'name'
          },
          {
            text: 'Email',
            align: 'left',
            sortable: true,
            value: 'email'
          },
          {
            text: 'RSVP',
            align: 'left',
            sortable: true,
            value: 'rsvp'
          },
          {
            text: 'Tickets',
            align: 'left',
            sortable: true,
            value: 'tickets'
          },
          {
            text: 'Drink Tickets',
            align: 'left',
            sortable: true,
            value: 'tickets'
          },
          {
            text: 'Allergies',
            align: 'left',
            sortable: true,
            value: 'dietary'
          },
          {
            text: 'Seating Requests',
            align: 'left',
            sortable: true,
            value: 'additional'
          },
          {
            text: '',
            align: 'right',
            sortable: false,
          }
        ]
			}
		},

    components: {
      'rsvp-form': RsvpForm
    },

    methods: {
      openDialog (item){
        this.editDialog = true;
        this.selectedGuest = item;
      },
      closeDialog (){
        this.editDialog = false;
        this.selectedGuest = {};
      },
      saved (rsvp){
        this.closeDialog();
        var index = Helpers.pluckObjectById(this.guests, 'id', rsvp.id);
        // Have to remove to trigger computed prop in components
        this.guests.splice(index, 1);
        // Re-add updated payload at same index
        return this.guests.splice(index, 0, rsvp);
      }
    },
		created (){
      axios.get('/guests/all')
    	 .then((response) => {
         console.log(response);
         this.guests = response.data;
         this.loading = false;
       })
       .catch((error) => {
         console.log(error);
       });
		},

	}
</script>
