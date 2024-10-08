<style scoped>
.action-link {
  cursor: pointer;
}

.m-b-none {
  margin-bottom: 0;
}
</style>

<template>
  <div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>
                        OAuth Clients
                    </span>

          <a class="action-link" @click="showCreateClientForm">
            Create New Client
          </a>
        </div>
      </div>

      <div class="panel-body">
        <!-- Current Clients -->
        <p v-if="clients.length === 0" class="m-b-none">
          You have not created any OAuth clients.
        </p>

        <table v-if="clients.length > 0" class="table table-borderless m-b-none">
          <thead>
          <tr>
            <th>Client ID</th>
            <th>Name</th>
            <th>Secret</th>
            <th></th>
            <th></th>
          </tr>
          </thead>

          <tbody>
          <tr v-for="client in clients">
            <!-- ID -->
            <td style="vertical-align: middle;">
              {{ client.id }}
            </td>

            <!-- Name -->
            <td style="vertical-align: middle;">
              {{ client.name }}
            </td>

            <!-- Secret -->
            <td style="vertical-align: middle;">
              <code>{{ client.secret }}</code>
            </td>

            <!-- Edit Button -->
            <td style="vertical-align: middle;">
              <a class="action-link" @click="edit(client)">
                Edit
              </a>
            </td>

            <!-- Delete Button -->
            <td style="vertical-align: middle;">
              <a class="action-link text-danger" @click="destroy(client)">
                Delete
              </a>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Create Client Modal -->
    <div id="modal-create-client" class="modal fade" role="dialog" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" class="close" data-dismiss="modal" type="button ">&times;</button>

            <h4 class="modal-title">
              Create Client
            </h4>
          </div>

          <div class="modal-body">
            <!-- Form Errors -->
            <div v-if="createForm.errors.length > 0" class="alert alert-danger">
              <p><strong>Whoops!</strong> Something went wrong!</p>
              <br>
              <ul>
                <li v-for="error in createForm.errors">
                  {{ error }}
                </li>
              </ul>
            </div>

            <!-- Create Client Form -->
            <form class="form-horizontal" role="form">
              <!-- Name -->
              <div class="form-group">
                <label class="col-md-3 control-label">Name</label>

                <div class="col-md-7">
                  <input id="create-client-name" v-model="createForm.name" class="form-control"
                         type="text" @keyup.enter="store">

                  <span class="help-block">
                                        Something your users will recognize and trust.
                                    </span>
                </div>
              </div>

              <!-- Redirect URL -->
              <div class="form-group">
                <label class="col-md-3 control-label">Redirect URL</label>

                <div class="col-md-7">
                  <input v-model="createForm.redirect" class="form-control" name="redirect"
                         type="text" @keyup.enter="store">

                  <span class="help-block">
                                        Your application's authorization callback URL.
                                    </span>
                </div>
              </div>
            </form>
          </div>

          <!-- Modal Actions -->
          <div class="modal-footer">
            <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>

            <button class="btn btn-primary" type="button" @click="store">
              Create
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Client Modal -->
    <div id="modal-edit-client" class="modal fade" role="dialog" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" class="close" data-dismiss="modal" type="button ">&times;</button>

            <h4 class="modal-title">
              Edit Client
            </h4>
          </div>

          <div class="modal-body">
            <!-- Form Errors -->
            <div v-if="editForm.errors.length > 0" class="alert alert-danger">
              <p><strong>Whoops!</strong> Something went wrong!</p>
              <br>
              <ul>
                <li v-for="error in editForm.errors">
                  {{ error }}
                </li>
              </ul>
            </div>

            <!-- Edit Client Form -->
            <form class="form-horizontal" role="form">
              <!-- Name -->
              <div class="form-group">
                <label class="col-md-3 control-label">Name</label>

                <div class="col-md-7">
                  <input id="edit-client-name" v-model="editForm.name" class="form-control"
                         type="text" @keyup.enter="update">

                  <span class="help-block">
                                        Something your users will recognize and trust.
                                    </span>
                </div>
              </div>

              <!-- Redirect URL -->
              <div class="form-group">
                <label class="col-md-3 control-label">Redirect URL</label>

                <div class="col-md-7">
                  <input v-model="editForm.redirect" class="form-control" name="redirect"
                         type="text" @keyup.enter="update">

                  <span class="help-block">
                                        Your application's authorization callback URL.
                                    </span>
                </div>
              </div>
            </form>
          </div>

          <!-- Modal Actions -->
          <div class="modal-footer">
            <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>

            <button class="btn btn-primary" type="button" @click="update">
              Save Changes
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  /*
   * The component's data.
   */
  data() {
    return {
      clients: [],

      createForm: {
        errors: [],
        name: '',
        redirect: ''
      },

      editForm: {
        errors: [],
        name: '',
        redirect: ''
      }
    };
  },

  /**
   * Prepare the component (Vue 1.x).
   */
  ready() {
    this.prepareComponent();
  },

  /**
   * Prepare the component (Vue 2.x).
   */
  mounted() {
    this.prepareComponent();
  },

  methods: {
    /**
     * Prepare the component.
     */
    prepareComponent() {
      this.getClients();

      $('#modal-create-client').on('shown.bs.modal', () => {
        $('#create-client-name').focus();
      });

      $('#modal-edit-client').on('shown.bs.modal', () => {
        $('#edit-client-name').focus();
      });
    },

    /**
     * Get all of the OAuth clients for the user.
     */
    getClients() {
      this.$http.get('/oauth/clients')
          .then(response => {
            this.clients = response.data;
          });
    },

    /**
     * Show the form for creating new clients.
     */
    showCreateClientForm() {
      $('#modal-create-client').modal('show');
    },

    /**
     * Create a new OAuth client for the user.
     */
    store() {
      this.persistClient(
          'post', '/oauth/clients',
          this.createForm, '#modal-create-client'
      );
    },

    /**
     * Edit the given client.
     */
    edit(client) {
      this.editForm.id = client.id;
      this.editForm.name = client.name;
      this.editForm.redirect = client.redirect;

      $('#modal-edit-client').modal('show');
    },

    /**
     * Update the client being edited.
     */
    update() {
      this.persistClient(
          'put', '/oauth/clients/' + this.editForm.id,
          this.editForm, '#modal-edit-client'
      );
    },

    /**
     * Persist the client to storage using the given form.
     */
    persistClient(method, uri, form, modal) {
      form.errors = [];

      this.$http[method](uri, form)
          .then(response => {
            this.getClients();

            form.name = '';
            form.redirect = '';
            form.errors = [];

            $(modal).modal('hide');
          })
          .catch(response => {
            if (typeof response.data === 'object') {
              form.errors = _.flatten(_.toArray(response.data));
            } else {
              form.errors = ['Something went wrong. Please try again.'];
            }
          });
    },

    /**
     * Destroy the given client.
     */
    destroy(client) {
      this.$http.delete('/oauth/clients/' + client.id)
          .then(response => {
            this.getClients();
          });
    }
  }
}
</script>
