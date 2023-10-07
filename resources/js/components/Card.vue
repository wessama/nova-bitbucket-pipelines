<template>
  <card class="flex flex-col">
    <div v-if="loading" class="flex justify-center items-center h-full">
      <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" opacity=".25"/>
        <path
            d="M10.14,1.16a11,11,0,0,0-9,8.92A1.59,1.59,0,0,0,2.46,12,1.52,1.52,0,0,0,4.11,10.7a8,8,0,0,1,6.66-6.61A1.42,1.42,0,0,0,12,2.69h0A1.57,1.57,0,0,0,10.14,1.16Z"
            class="spinner_ajPY"/>
      </svg>
      <p>Fetching pipeline status...</p>
    </div>
    <div v-else class="px-3 py-3">
      <h1 class="text-3xl text-80 font-light">Pipelines</h1>
      <ul>
        <li v-for="pipeline in resources">
          Branch:
          <a :href="pipeline.href">
            {{ pipeline.target.ref_name }}
          </a>
          {{ getPipelineStatus(pipeline) }}
        </li>
      </ul>
    </div>
  </card>
</template>

<script>
import {ref, onMounted} from 'vue';

export default {
  props: ['card'],
  setup() {
    const loading = ref(true);
    const resources = ref([]);

    onMounted(() => {
      Nova.request().get('/nova-vendor/pipelines')
          .then((response) => {
            loading.value = false;
            resources.value = response.data.resources;
          })
          .catch((err) => console.error(err));
    });

    const getPipelineStatus = (pipeline) => {
      if (pipeline.state.name === "IN_PROGRESS" || pipeline.state.name === "PENDING") {
        return 'Pending';
      } else if (pipeline.state.result.name === "SUCCESSFUL") {
        return '✅';
      } else {
        return '❌';
      }
    };

    return {
      loading,
      resources,
      getPipelineStatus,
    };
  },
};
</script>

<style>
.spinner_ajPY {
  transform-origin: center;
  animation: spinner_AtaB .75s infinite linear
}

@keyframes spinner_AtaB {
  100% {
    transform: rotate(360deg)
  }
}
</style>
