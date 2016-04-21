<template>
	<nav>
		<ul class="pagination u-no-margin u-unselectable">
			<li :class="(page == 1)?'disabled':'u-pointer'">
				<a @click="pageInput(page - 1)">
					<span>&laquo;</span>
				</a>
			</li>

			<li :class="(page == 1)?'active':'u-pointer'" @click="pageInput(1)">
				<a>1</a>
			</li>

			<li v-if="page > 4" class="disabled">
				<a>...</a>
			</li>

			<li v-if="page > 3" @click="pageInput(page - 2)" class="u-pointer">
				<a>{{ page - 2 }}</a>
			</li>

			<li v-if="page > 2" @click="pageInput(page - 1)" class="u-pointer">
				<a>{{ page - 1 }}</a>
			</li>

			<li v-if="page > 1 && page < pages" class="active">
				<a>{{ page }}</a>
			</li>

			<li v-if="page < pages - 1" @click="pageInput(page + 1)" class="u-pointer">
				<a>{{ page + 1 }}</a>
			</li>

			<li v-if="page < pages - 2" @click="pageInput(page + 2)" class="u-pointer">
				<a>{{ page + 2 }}</a>
			</li>

			<li v-if="page < pages - 3" class="disabled">
				<a>...</a>
			</li>

			<li :class="(page == pages)?'active':'u-pointer'" @click="pageInput(pages)" v-if="pages > 1">
				<a>{{ pages }}</a>
			</li>


			<li :class="(page == pages)?'disabled':''">
				<a @click="pageInput(page + 1)">
					<span>&raquo;</span>
				</a>
			</li>
		</ul>
	</nav>
</template>

<script>
module.exports = {
	props: ['pages', 'mode'],

	computed: {
		page() {
			if (this.mode == 'offers') {
				return this.offersPage + 1
			} else if (this.mode == 'invoices') {
				return this.invoicesPage + 1
			}
		}
	},

	methods: {
		pageInput(page) {
			this.changePage(this.mode, page - 1)
			this.$dispatch('GET')
		}
	},

	vuex: {
		getters: {
			invoicesPage: state => state.invoices.page,
			offersPage: state => state.offers.page
		},

		actions: require(`app/vuex/actions/dataTables.js`)
	}
}
</script>