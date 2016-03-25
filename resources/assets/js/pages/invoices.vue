<template>
<input type="text" v-mask="(###) ###-####" placeholder="(000) 000-0000">
<input type="text" v-mask="#### #### #### ####" placeholder="0000 0000 0000 0000">
<input type="text" v-mask:rtl="#,###,###,###.##" style="text-align: right;" placeholder="0.00">
</template>

<script>
module.exports = {
	data () {
		return {
			test: ""
		}
	}
}
</script>