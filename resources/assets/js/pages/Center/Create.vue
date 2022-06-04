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
        <label for="user">User</label>
        <select class="form-control" name="user_id" v-model="record.user_id">
          <option value="0">Select User</option>
          <option v-for="data in users" :value="data.id">
            {{ data.name }}
          </option>
        </select>
        <span v-if="errors.user_id" class="text-danger">
          <small v-text="errors.user_id[0]"></small>
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
  axios.get("/getUser").then(
        function (response) {
            console.log(response);
          this.users = response.data;
        }.bind(this)
      );
    },
  methods: {
   
    saveRecord() {
      axios
        .post("/centers", this.record)
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