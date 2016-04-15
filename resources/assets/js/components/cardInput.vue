<template>
<input type="text" class="form-control" id="card-number"
	v-mask :mask="mask">
</template>

<script>
module.exports = {
	data() {
		return {
			number: '',
			mask: "#### #### #### ####",
			cardType: "Undefined",
			filled: false,
			validLuhn: false
		}
	}
}
</script>