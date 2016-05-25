<template>
<p>
	<div>
		<b>{{ address.first_name }} {{ address.last_name }}</b> <span v-if="address.company">of {{ address.company }}</span>
	</div>
	<div v-if="address.street">
		{{ address.street }}
	</div>
	<div v-if="address.street_second">
		{{ address.street_second }}
	</div>
	<div v-if="address.apt">
		(Apt/Suite/Bld) # {{ address.apt }}
	</div>
	<div v-if="address.city || address.state || address.zip">
		{{ address.city }}<span v-if="address.state || address.zip">, {{ address.state }} {{ address.zip }}
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