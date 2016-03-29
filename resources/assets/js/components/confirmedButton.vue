<template>
<button class="btn btn-sm btn-block btn-default">
	<i :class="'fa ' + icon"></i> {{ text }}
</button>
</template>

<script>
module.exports = {
	props: ['icon', 'text', 'action']
}
</script>