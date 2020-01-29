<template>
  <div v-if="job_id">
    <p>Created at: {{ created_at }}</p>
    <p>Started at: {{ started_at }}</p>
    <p>Finished at: {{ finished_at }}</p>
    <div class="progress progress-lg">
      <div
        :class="`progress-bar progress-bar-striped progress-bar-animate ${colorClass}`"
        role="progressbar"
        :style="`width: ${current}%;`"
        :aria-valuenow="current"
        :aria-valuemin="min"
        :aria-valuemax="max"
      >{{statusText}}: {{ current}}%</div>
    </div>

    <div class="alert alert-danger" role="alert" v-if="errors && errors.length > 0">
      <div class="alert-icon">
        <i class="flaticon-exclamation-1"></i>
      </div>
      <div class="alert-text">
        <ul>
          <li v-for="(error, index) in errors" :key="index">{{error}}</li>
        </ul>
      </div>
      <div class="alert-close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">
            <i class="la la-close"></i>
          </span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    job_id: {
      type: Number,
      default: 1
    }
  },
  data() {
    return {
      max: 100,
      min: 0,
      current: 0,
      errors: [],
      interval: null,
      created_at: "",
      started_at: "",
      finished_at: "",
      status: ""
    };
  },
  computed: {
    statusText() {
      switch (this.status) {
        case "submitted":
          return "Submitted";
          break;
        case "queued":
          return "Queued";
          break;
        case "processing":
          return "Processing";
          break;
        case "executing":
          return "Processing";
          break;
        case "failed":
          return "Failed";
          break;
        case "finished":
          return "Finished";
          break;
        case "partially_finished":
          return "Partially Finished";
          break;
        default:
          return "";
          break;
      }
    },
    colorClass() {
      switch (this.status) {
        case "submitted":
          return "bg-dark";
          break;
        case "queued":
          return "bg-info";
          break;
        case "finished":
          return "bg-success";
          break;
        case "failed":
          return "bg-danger";
          break;
        case "partially_finished":
          return "bg-warning";
          break;
        default:
          return "";
          break;
      }
    }
  },
  methods: {
    loadData: function() {
      window.axios
        .get(`/jobs/${this.job_id}/progress`)
        .then(response => {
          if (response.status === 200) {
            this.status = response.data.status;
            this.max =
              response.data.progress_max > 0 ? response.data.progress_max : 100;
            this.current =
              Math.round((response.data.progress_now / this.max) * 10000) / 100;
            this.created_at = response.data.created_at;
            this.started_at = response.data.started_at;
            this.finished_at = response.data.finished_at;
            if (this.status == "failed") {
              this.errors = response.data.output.errors;
            }
            if (
              this.status == "failed" ||
              this.status == "partially_finished" ||
              this.status == "finished"
            ) {
              clearInterval(this.interval);
              document.location.href = document.location;
            }
          }
        })
        .catch(function(error) {
          console.log(error);
        });
    }
  },
  mounted() {
    this.loadData();

    this.interval = setInterval(
      function() {
        this.loadData();
      }.bind(this),
      5000
    );
  },

  beforeDestroy: function() {
    clearInterval(this.interval);
  }
};
</script>

<style scoped>
</style>
