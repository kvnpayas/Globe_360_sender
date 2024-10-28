<script setup>
  
</script>
<template>
  <nav class="bg-primary shadow-lg shadow-accent">
    <div class="flex justify-between mx-auto max-w-7xl py-2 px-4">
      <div class="flex space-x-4">
        <img src="/public/img/tei-logo-no-name.png" alt="My Image" style="height: 38px;" />
        <i class="fa-solid fa-comment-sms mt-0.5 text-secondary text-3xl"></i>
      </div>
      <div class="space-x-6 text-white mt-2">
        <Link href="/">Home</Link>
        <!-- <Link href="/sms-setting">SMS Settings</Link> -->
        <Link href="/setting">Settings</Link>
        <!-- <a href="/">Home</a>
        <a href="/setup">Setup</a> -->
      </div>
    </div>
  </nav>
</template>