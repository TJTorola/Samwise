<template>
	<nav>
		<ul class="pagination u-no-margin u-unselectable">
			<li :class="(page == 1)?'disabled':'u-pointer'">
				<a @click="changePage(page - 1)">
					<span>&laquo;</span>
				</a>
			</li>

			<li :class="(page == 1)?'active':'u-pointer'" @click="changePage(1)">
				<a>1</a>
			</li>

			<li v-if="page > 4" class="disabled">
				<a>...</a>
			</li>

			<li v-if="page > 3" @click="changePage(page - 2)" class="u-pointer">
				<a>{{ page - 2 }}</a>
			</li>

			<li v-if="page > 2" @click="changePage(page - 1)" class="u-pointer">
				<a>{{ page - 1 }}</a>
			</li>

			<li v-if="page > 1 && page < pages" class="active">
				<a>{{ page }}</a>
			</li>

			<li v-if="page < pages - 1" @click="changePage(page + 1)" class="u-pointer">
				<a>{{ page + 1 }}</a>
			</li>

			<li v-if="page < pages - 2" @click="changePage(page + 2)" class="u-pointer">
				<a>{{ page + 2 }}</a>
			</li>

			<li v-if="page < pages - 3" class="disabled">
				<a>...</a>
			</li>

			<li :class="(page == pages)?'active':'u-pointer'" @click="changePage(pages)" v-if="pages > 1">
				<a>{{ pages }}</a>
			</li>


			<li :class="(page == pages)?'disabled':''">
				<a @click="changePage(page + 1)">
					<span>&raquo;</span>
				</a>
			</li>
		</ul>
	</nav>
</template>

<script>
module.exports = {
	props: {
		page: {
			type: Number,
			coerce (page) {
				return page + 1
			}
		},

		pages: {
			type: Number
		}
	},

	methods: {
		changePage(page) {
			this.$dispatch("CHANGE_PAGE", page - 1)
		}
	}
}
</script>