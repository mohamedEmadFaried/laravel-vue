<template>
  <modal-layouts
    name="addRecord"
    id="addRecord"
    @keydown.esc="clearModal"
    @click.left="clearModal"
  >
    <template slot="heading">Add Record</template>

    <template slot="main">
      <div class="form-group">
        <label for="name">Name</label>

        <input
          type="text"
          name="name"
          id="name"
          class="form-control"
          v-model="record.name"
          @keydown="delete errors.name"
        />

        <span v-if="errors.name" class="text-danger">
          <small v-text="errors.name[0]"></small>
        </span>
      </div>

     <div class="form-group">
        <label for="Center">Center</label>
        <select class="form-control" v-model="record.center_id">
          <option value="0">Select Center</option>
          <option v-for="dataCenter in centers" :value="dataCenter.id">
            {{ dataCenter.name }}
          </option>
        </select>
        <span v-if="errors.center_id" class="text-danger">
          <small v-text="errors.center_id[0]"></small>
        </span>
      </div>
    </template>

    <template slot="footer">
      <button
        type="button"
        class="btn btn-outline-secondary"
        @click="clearModal"
        data-dismiss="modal"
      >
        Close
      </button>

      <button type="submit" class="btn btn-outline-primary" @click="saveRecord">
        Save
      </button>
    </template>
  </modal-layouts>
</template>

<script>
import ModalLayouts from "../../partials/ModalLayouts";

export default {
  data() {
    return {
      record: {},
      errors: [],
    };
  },

  components: { ModalLayouts },

   mounted(){
  axios.get("/getCenter").then(
        function (response) {
            console.log(response);
          this.centers = response.data;
        }.bind(this)
      );
    },
  methods: {
    saveRecord() {
      axios
        .post("/doctors", this.record)
        .then((data) => {
          this.$emit("recordAdded", data);

          toast({
            type: "success",
            title: "Record has been added successfully!",
          });

          this.record = {};
          $("#addRecord").modal("hide");
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },

    clearModal() {
      this.errors = [];
      this.record = {};
    },
  },
};
</script>