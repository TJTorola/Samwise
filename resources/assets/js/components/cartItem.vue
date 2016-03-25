<template>
<li>
	<div class="pull-left">
		<img :src="">
	</div>
	<h4>
		<a>{{ item.name }}</a>
	</h4>
	<p v-for="variant in item.variants" class="unselectable">
		{{ variant.name }} {{ variant.price | currency }} / <i>{{ variant.unit }}</i><br>
		<i class="fa fa-chevron-down" 
			@click.stop="modifyOrder(item, variant, -1)"
			:class="(variant.in_cart > 0)?'active':''"></i>
		&nbsp;{{ variant.in_cart }}&nbsp;
		<i class="fa fa-chevron-up active" @click.stop="modifyOrder(item, variant, 1)"></i> 
		<span class="pull-right">
			{{ variant.price * variant.in_cart | currency }}
		</span>
	</p>
</li>
</template>

<script>
module.exports = {
	props: ['item']
}
</script>