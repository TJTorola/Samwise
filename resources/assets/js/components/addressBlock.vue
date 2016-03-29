<template>
<p>
	<div>
		<b>{{ address.first_name }} {{ address.last_name }}</b> <span v-if="address.company">of {{ address.company }}</span>
	</div>
	{{ address.street }}
	<div v-if="address.street_second">
		{{ address.street_second }}
	</div>
	<div v-if="address.apt">
		{{ address.apt }}
	</div>
	<div>
		{{ address.city }}, {{ address.state }} {{ address.zip }}
	</div>
	<div v-if="address.country != 'USA'">
		{{ address.country }}
	</div>
</p>
</template>

<script>
module.exports = {
	props: ['address']
}
</script>