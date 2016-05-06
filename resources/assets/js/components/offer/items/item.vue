<template>
<div>
	<general-form :item="item"></general-form>
	<type-form :item="item"></type-form>
</div>
</template>

<script>
module.exports = {
	props: ['item'],
	
	components: {
		generalForm: require('./generalForm.vue'),
		typeForm: require('./typeForm.vue')
	}
}
</script>