<script setup>
import Nav from '../Layouts/Nav.vue';
import Process from '../Layouts/Process.vue';

</script>
<template>
  <div>
    <header>
      <Nav />
    </header>
    <main>
      <Process />
      <slot />
    </main>
  </div>
</template>