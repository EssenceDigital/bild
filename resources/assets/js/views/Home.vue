<template>
	<layout>
		<h2 slot="title" class="primary--text font-weight-thin">
			<v-icon large color="primary">dashboard</v-icon> Dashboard
		</h2>

		<div slot="tools">

		</div>
		<div slot="content">

			<guests-table></guests-table>

		</div><!--/ Content slot -->
	</layout>
</template>

<script>
	import Layout from './_Layout';
	import GuestsTable from './../components/Guests-table';

	export default{
		data () {
			return {

			}
		},
		components: {
			'layout': Layout,
			'guests-table': GuestsTable
		},
		methods: {

		}
	}
</script>
