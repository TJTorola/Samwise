<template>
<div class="box box-warning">
	<div class="box-header">
		<h3 class="box-title"><i class="fa fa-check-square-o"></i> User Privileges</h3>

		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div>
	<div class="box-body">
		<table class="table">
			<thead>
				<tr>
					<th></th>
					<!-- Following headers are rotated -->
					<th class="rotate"><div><span>Admin</span></div></th>
					<th class="rotate"><div><span>Catalogs</span></div></th>
					<th class="rotate"><div><span>Customers</span></div></th>
					<th class="rotate"><div><span>Inventory</span></div></th>
					<th class="rotate"><div><span>Invoices</span></div></th>
					<th class="rotate"><div><span>Pages</span></div></th>
				</tr> 
			</thead>
			<tbody>
				<tr is="user-row" v-for="user in users" :user="user"></tr>
			</tbody>
		</table>
	</div>
</div>
</template>

<script>
module.exports = {
	data() {
		return {
			users: []
		}
	},

	ready() {
		this.get()
	},

	components: {
		userRow: require('./userRow.vue')
	},

	methods: {
		get () {
			this.$http.get('users').then(response => {
				this.$set('users', response.data.body)
			})
		},

		modifyPrivilege ()
		{

		}
	}
}
</script>

<style scoped>
.table > thead > tr > th, .table > tbody > tr > th, 
.table > tfoot > tr > th, .table > thead > tr > td, 
.table > tbody > tr > td, .table > tfoot > tr > td {
	padding: 8px 0;
}

th.rotate {
	position: relative;
	white-space: nowrap;
	top: -53px;
	left: -20px;
	white-space: nowrap;
}

th.rotate > div {
	transform: 
		translate(25px, 51px)
		rotate(315deg);
	width: 30px;
}
</style>