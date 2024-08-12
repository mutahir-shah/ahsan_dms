"use strict";

class DispatcherPanel extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
        body: "dispatch-map",
        selected: "all",
        searchValue: '',
        initialData: props.initialData || {}
    };
  }

  componentWillMount() {
    console.log(this.state.initialData)
    this.setState({
      listContent: "dispatch-map",
      searchTerm: ''
    });
  }

  handleUpdateBody(body) {
    // console.log("Body Update Called", body);
    this.setState({
      listContent: body,
    });
  }

  handleUpdateFilter(filter) {
    // console.log("Filter Update Called", this.state.listContent);
    if (filter == "all") {
      this.setState({
        listContent: "dispatch-map",
      });
    } else if (filter == "cancelled") {
      this.setState({
        listContent: "dispatch-cancelled",
      });
    } else if (filter == "return") {
      this.setState({
        listContent: "dispatch-return",
      });
    } else if (filter == "scheduled") {
      this.setState({
        listContent: "dispatch-scheduled",
      });
    } else {
      this.setState({
        listContent: "dispatch-map",
      });
    }
  }

  handleRequestShow(trip) {
    // console.log('Show Request', trip);
    const canChangeProvider = ['SEARCHING', 'ACCEPTED', 'ASSIGNED', 'ARRIVED', 'SCHEDULED'].includes(trip.status);
    if (trip.current_provider_id == 0 || canChangeProvider) {
      this.setState({
        listContent: "dispatch-assign",
        trip: trip,
      });
    } else {
      this.setState({
        listContent: "dispatch-map",
        trip: trip,
      });
    }
    ongoingInitialize(trip);
  }

  handleRequestCancel(argument) {
    this.setState({
      listContent: "dispatch-map",
    });
  }

  render() {
    let listContent = null;

    // console.log('DispatcherPanel', this.state.listContent);

    switch (this.state.listContent) {
      case "dispatch-create":
        listContent = (
          <div className="col-md-4 h-100" >
            <DispatcherRequest
              initialData={this.state.initialData}
              completed={this.handleRequestShow.bind(this)}
              cancel={this.handleRequestCancel.bind(this)}
            />
          </div>
        );
        break;
      case "dispatch-map":
        listContent = (
          <div className="col-md-4 h-100">
            <DispatcherList initialData={this.state.initialData} searchTerm={this.state.searchTerm} clicked={this.handleRequestShow.bind(this)} />
          </div>
        );
        break;
      case "dispatch-cancelled":
        listContent = (
          <div className="col-md-4 h-100">
            <DispatcherCancelledList initialData={this.state.initialData} searchTerm={this.state.searchTerm} />
          </div>
        );
        break;
      case "dispatch-assign":
        listContent = (
          <div className="col-md-4 h-100">
            <DispatcherAssignList initialData={this.state.initialData} searchTerm={this.state.searchTerm} trip={this.state.trip} />
          </div>
        );
        break;
      case "dispatch-scheduled":
        listContent = (
          <div className="col-md-4 h-100">
            <DispatcherScheduledList searchTerm={this.state.searchTerm} initialData={this.state.initialData}/>
          </div>
        );
        break;
    }

    return (
      <div className="container-fluid">
        <h4>{ this.state.initialData.dispatcher }</h4>

        <DispatcherNavbar
          onSearch={searchTerm => this.setState({ searchTerm })}
          body={this.state.listContent}
          updateBody={this.handleUpdateBody.bind(this)}
          updateFilter={this.handleUpdateFilter.bind(this)}
          initialData={this.state.initialData}
        />

        <div className="row" style={{ height: '90vh', overflow: 'scroll' }}>
          {listContent}

          <div className="col-md-8">
            <DispatcherMap body={this.state.listContent} initialData={this.state.initialData}/>
          </div>
        </div>
      </div>
    );
  }
}

class DispatcherNavbar extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      body: "dispatch-map",
      selected: "all",
      searchValue: ''
    };
  }


  filter(data) {
    // console.log("Navbar Filter", data);
    this.setState({ selected: data });
    this.props.updateFilter(data);
  }

  handleBodyChange() {
    // console.log('handleBodyChange', this.state);
    if (this.props.body != this.state.body) {
      this.setState({
        body: this.props.body,
      });
    }

    if (this.state.body == "dispatch-map") {
      this.props.updateBody("dispatch-create");
      this.setState({
        body: "dispatch-create",
      });
    } else if (this.state.body == "dispatch-cancelled") {
      this.props.updateBody("dispatch-map");
      this.setState({
        body: "dispatch-cancelled",
      });
    } else if (this.state.body == "dispatch-scheduled") {
      this.props.updateBody("dispatch-map");
      this.setState({
        body: "dispatch-scheduled",
      });
    } else {
      this.props.updateBody("dispatch-map");
      this.setState({
        body: "dispatch-map",
      });
    }
  }

  isActive(value) {
    return "nav-item " + (value === this.state.selected ? "active" : "");
  }

  handleSearch(e) {
    const searchValue = e.target.value;
    this.setState({ searchValue });
    this.props.onSearch(searchValue);
  }

  render() {
    return (
      <nav className="navbar navbar-light bg-white b-a mb-2">
        <button
          className="navbar-toggler hidden-md-up"
          data-toggle="collapse"
          data-target="#process-filters"
          aria-controls="process-filters"
          aria-expanded="false"
          aria-label="Toggle Navigation"
        ></button>

        <form className="form-inline navbar-item ml-1 float-xs-right" onSubmit={e => e.preventDefault()}>
          <div className="input-group">
            <input
              type="text"
              className="form-control b-a"
              placeholder="Search for..."
              value={this.state.searchValue}
              onChange={this.handleSearch.bind(this)}
            />
          </div>
        </form>

        <ul className="nav navbar-nav float-xs-right">
          {this.props.initialData.add_permission && (
             <li className="nav-item">
             <button
               type="button"
               onClick={this.handleBodyChange.bind(this)}
               className="btn btn-success btn-md label-right b-a-0 waves-effect waves-light"
             >
               <span className="btn-label">
                 <i className="ti-plus"></i>
               </span>
               { this.props.initialData.add }
             </button>
           </li>
          ) }
         
        </ul>

        <div className="collapse navbar-toggleable-sm" id="process-filters">
          <ul className="nav dispatcher-nav">
            <li
              className={this.isActive("all")}
              onClick={this.filter.bind(this, "all")}
            >
              <span className="nav-link active" href="#">
                { this.props.initialData.active_jobs }
              </span>
            </li>
            <li
              className={this.isActive("cancelled")}
              onClick={this.filter.bind(this, "cancelled")}
            >
              <span className="nav-link" href="#">
              { this.props.initialData.cancelled_jobs }
              </span>
            </li>
            {/* <li
              className={this.isActive("scheduled")}
              onClick={this.filter.bind(this, "scheduled")}
            >
              <span className="nav-link" href="#">
                Scheduled
              </span>
            </li> */}
          </ul>
        </div>
      </nav>
    );
  }
}
class DispatcherScheduledList extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      trips: [],
      show_otp: false
    };
  }

  componentDidMount() {
    window.worldMapInitialize();
    window.Tranxit.TripTimer = setInterval(() => this.getTripsUpdate(), 1000);
  }

  componentWillUnmount() {
    clearInterval(window.Tranxit.TripTimer);
  }

  getTripsUpdate() {
    const q = this.props.searchTerm;
    let url = `/admin/dispatcher/trips?type=SCHEDULED`;
    if (q !== undefined)
      url += `&q=${q}`;

    $.get(
      url,
      function (result) {
        if (result.hasOwnProperty("trips")) {
          this.setState({
            trips: result.trips,
            show_otp: result.show_otp
          });
        } else {
          this.setState({
            trips: [],
            show_otp: false
          });
        }
      }.bind(this)
    );
  }

  render() {
    return (
      <div className="card">
        <div className="card-header text-uppercase">
          <b>{ this.props.initialData.scheduled_list }</b>
        </div>
        <DispatcherScheduledListItem
          initialData={this.props.initialData}
          trips={this.state.trips}
          show_otp={this.state.show_otp} />
      </div>
    );
  }
}

class DispatcherScheduledListItem extends React.Component {
  render() {
    const { trips, show_otp, initialData } = this.props;
    var listItem = function (trip) {
      return (
        <div className="il-item" key={trip.id}>
          <a className="text-black" href="#">
            <div className="media">
              <div className="media-body">
                <p className="mb-0-5">
                  {trip.user ? trip.user.first_name : "N/A"}{" "}
                  {trip.user ? trip.user.last_name : "N/A"}
                  {trip.status == "COMPLETED" ? (
                    <span className="tag tag-success pull-right">
                      {" "}
                      {initialData[`${trip.status.toLowerCase()}`]}{" "}
                    </span>
                  ) : trip.status == "CANCELLED" ? (
                    <span className="tag tag-danger pull-right">
                      {" "}
                      {initialData[`${trip.status.toLowerCase()}`]}{" "}
                    </span>
                  ) : trip.status == "SEARCHING" ? (
                    <span className="tag tag-warning pull-right">
                      {" "}
                      {initialData[`${trip.status.toLowerCase()}`]}{" "}
                    </span>
                  ) : trip.status == "SCHEDULED" && trip.provider_id == "0" ? (
                    <span className="tag tag-primary pull-right">
                      {" "}
                      {initialData[`${trip.status.toLowerCase()}`]} | {initialData.pending}
                    </span>
                  ) : trip.status == "SCHEDULED" ? (
                    <span className="tag tag-primary pull-right">
                      {" "}
                      {initialData[`${trip.status.toLowerCase()}`]}{" "}
                    </span>
                  ) : trip.status == "REQUESTED" && trip.provider_id == "0" ? (
                    <span className="tag tag-primary pull-right">
                      {" "}
                      {initialData[`${trip.status.toLowerCase()}`]}{" "} | {initialData.pending}
                    </span>
                  ) : trip.status == "REQUESTED" ? (
                    <span className="tag tag-primary pull-right">
                      {" "}
                      {initialData[`${trip.status.toLowerCase()}`]}{" "} | {initialData.pending}
                    </span>
                  ) : (
                    <span className="tag tag-info pull-right">
                      {" "}
                      {initialData[`${trip.status.toLowerCase()}`]}{" "}
                    </span>
                  )}
                </p>
                <h6 className="media-heading">{initialData.from}: {trip.s_address}</h6>
                <h6 className="media-heading">
                  To: {trip.d_address ? trip.d_address : "Not Selected"}
                </h6>
                <h6 className="media-heading">{initialData.payment}: {trip.payment_mode}</h6>
                {show_otp && <h6 className="media-heading">{initialData.otp}: {trip.otp}</h6>}
                <h6 className="media-heading">{initialData.type}: {trip.service_type.name}</h6>
                <span className="text-muted">
                  {initialData.scheduled_at} : {trip.schedule_at}
                </span>
              </div>
            </div>
          </a>
        </div>
      );
    }.bind(this);

    return (
      <div className="items-list">
        {trips.data && trips.data.map(listItem)}
      </div>
    );
  }
}

class DispatcherList extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      trips: [],
      show_otp: false
    };
  }

  componentDidMount() {
    window.worldMapInitialize();
    window.Tranxit.TripTimer = setInterval(() => this.getTripsUpdate(), 1000);
  }

  componentWillUnmount() {
    clearInterval(window.Tranxit.TripTimer);
  }

  getTripsUpdate() {
    const q = this.props.searchTerm;
    let url = `/admin/dispatcher/trips?type=SEARCHING`;
    if (q !== undefined)
      url += `&q=${q}`;

    $.get(
      url,
      function (result) {
        if (result.hasOwnProperty("trips")) {
          this.setState({
            trips: result.trips,
            show_otp: result.show_otp
          });
        } else {
          this.setState({
            trips: [],
            show_otp: false
          });
        }
      }.bind(this)
    );
  }

  handleClick(trip) {
    this.props.clicked(trip);
  }

  render() {
    return (
      <div className="card h-100" style={{ marginBottom: '0' }}>
        <div className="card-header text-uppercase">
          <b>{this.props.initialData.job_list}</b>
        </div>
        <DispatcherListItem
          initialData={this.props.initialData}
          trips={this.state.trips}
          show_otp={this.state.show_otp}
          clicked={this.handleClick.bind(this)}
        />
      </div>
    );
  }
}

class DispatcherCancelledList extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      trips: [],
      show_otp: false
    };
  }

  componentDidMount() {
    window.worldMapInitialize();
    window.Tranxit.TripTimer = setInterval(() => this.getTripsUpdate(), 1000);
  }

  componentWillUnmount() {
    clearInterval(window.Tranxit.TripTimer);
  }

  getTripsUpdate() {
    const q = this.props.searchTerm;
    let url = `/admin/dispatcher/trips?type=CANCELLED`;
    if (q !== undefined)
      url += `&q=${q}`;

    $.get(
      url,
      function (result) {
        if (result.hasOwnProperty("trips")) {
          this.setState({
            trips: result.trips,
            show_otp: result.show_otp
          });
        } else {
          this.setState({
            trips: [],
            show_otp: false
          });
        }
      }.bind(this)
    );
  }

  render() {
    return (
      <div className="card h-100" style={{ marginBottom: '0' }}>
        <div className="card-header text-uppercase">
          <b>{this.props.initialData.cancelled_list}</b>
        </div>
        <DispatcherCancelledListItem
          initialData={this.props.initialData}
          trips={this.state.trips}
          show_otp={this.state.show_otp} />
      </div>
    );
  }
}

class DispatcherCancelledListItem extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      trips: [],
      show_otp: false
    };
  }
  render() {
    const { trips, show_otp } = this.props;
    var listItem = function (trip) {
      return (
        <div className="il-item" key={trip.id}>
          <a className="text-black" href="#">
            <div className="media">
              <div className="media-body">
                <h5 className="media-heading mb-4"><b>{this.props.initialData.booking_id}: {trip.booking_id}</b></h5>
                <hr />
                <p className="mb-0-5">
                  {trip.user ? trip.user.first_name : "N/A"}{" "}
                  {trip.user ? trip.user.last_name : "N/A"}
                  {trip.status == "COMPLETED" ? (
                    <span className="tag tag-success pull-right">
                      {" "}
                      {this.props.initialData[trip.status.toLowerCase()]}{" "}
                    </span>
                  ) : trip.status == "CANCELLED" ? (
                    <span className="tag tag-danger pull-right">
                      {" "}
                      {this.props.initialData[trip.status.toLowerCase()]}{" "}
                    </span>
                  ) : trip.status == "SEARCHING" ? (
                    <span className="tag tag-warning pull-right">
                      {" "}
                      {this.props.initialData[trip.status.toLowerCase()]}{" "}
                    </span>
                  ) : trip.status == "SCHEDULED" && trip.provider_id == "0" ? (
                    <span className="tag tag-primary pull-right">
                      {" "}
                      {this.props.initialData[trip.status.toLowerCase()]}{" "} | {this.props.initialData.pending}
                    </span>
                  ) : trip.status == "SCHEDULED" ? (
                    <span className="tag tag-primary pull-right">
                      {" "}
                      {this.props.initialData[trip.status.toLowerCase()]}{" "}
                    </span>
                  ) : trip.status == "REQUESTED" && trip.provider_id == "0" ? (
                    <span className="tag tag-primary pull-right">
                      {" "}
                      {this.props.initialData[trip.status.toLowerCase()]}{" "} | {this.props.initialData.pending}
                    </span>
                  ) : trip.status == "REQUESTED" ? (
                    <span className="tag tag-primary pull-right">
                      {" "}
                      {this.props.initialData[trip.status.toLowerCase()]}{" "} | {this.props.initialData.pending}
                    </span>
                  ) : (
                    <span className="tag tag-info pull-right">
                      {" "}
                      {this.props.initialData[trip.status.toLowerCase()]}{" "}
                    </span>
                  )}
                </p>

                <div className='user_info__wrapper'>
                  <img
                    className="user_info__img" style={{ "height": "40px", "width": "40px", "borderRadius": "2rem" }}
                    src={'/storage/' + trip.user.picture || '/asset/img/default-avatar.png'}
                    onError={(e) => {
                      e.target.src = '/asset/img/default-avatar.png'
                    }} />
                  <h6><b>{this.props.initialData.user}</b><br />
                    {trip.user ? trip.user.first_name : "N/A"}{" "}
                    {trip.user ? trip.user.last_name : "N/A"}{" - "} {trip.user ? trip.user.mobile : "N/A"}</h6>
                </div>
                <hr />

                {trip.provider &&
                  <div className='user_info__wrapper'>

                    <img
                      className="user_info__img" style={{ "height": "40px", "width": "40px", "borderRadius": "2rem" }}
                      src={'/storage/' + (trip.provider ? trip.provider.avatar : '/asset/img/default-avatar.png')}
                      onError={(e) => {
                        e.target.src = '/asset/img/default-avatar.png'
                      }} />
                    <h6><b>{this.props.initialData.driver}</b><br />
                      {trip.provider ? trip.provider.first_name : "N/A"}{" "}
                      {trip.provider ? trip.provider.last_name : "N/A"}{" - "} {trip.provider ? trip.provider.mobile : "N/A"}</h6>

                  </div>
                }

                {trip.provider &&
                  <hr />
                }
                <h6 className="media-heading"><b>{this.props.initialData.from}:</b> {trip.s_address}</h6>
                <h6 className="media-heading">
                  <b>{this.props.initialData.to}</b>: {trip.d_address ? trip.d_address : "Not Selected"}
                </h6>
                <h6 className="media-heading"><b>{this.props.initialData.cancelled_by}:</b> {trip.cancelled_by}</h6>
                <h6 className="media-heading"><b>{this.props.initialData.cancelled_reason}:</b> {trip.cancel_reason}</h6>
                <h6 className="media-heading"><b>{this.props.initialData.payment}</b>: {trip.payment_mode}</h6>
                <h6 className="media-heading"><b>{this.props.initialData.amount}</b>: {trip.formatted_amount}</h6>
                <h6 className="media-heading"><b>{this.props.initialData.distance}</b>: {trip.formatted_distance}</h6>

                {show_otp && <h6 className="media-heading"><b>{this.props.initialData.otp}</b>: {trip.otp}</h6>}
                <h6 className="media-heading"><b>{this.props.initialData.type}: {trip.service_type.name}</b></h6>
                {trip.specialNote && <h6 className="media-heading"><b>{this.props.initialData.notes}</b>: {trip.specialNote}</h6>}

                {trip.status === 'SCHEDULED' && <h6 className="media-heading"><b>{this.props.initialData.schedule}</b>: {trip.schedule_at}</h6>}

                <progress
                  className="progress progress-success progress-sm"
                  max="100"
                ></progress>
                <span className="text-muted">
                  {this.props.initialData.cancelled_at} : {trip.updated_at}
                </span>
              </div>
            </div>
          </a>
        </div>
      );
    }.bind(this);

    return (
      <div className="items-list">
        {trips.data && trips.data.map(listItem)}
      </div>
    );
  }
}

class DispatcherListItem extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      trips: [],
      show_otp: false
    };
  }

  handleClick(trip) {
    this.props.clicked(trip);
  }

  render() {
    const { trips, show_otp, initialData } = this.props;
    console.log(initialData);
    var listItem = function (trip) {
      return (
        <div className="il-item" key={trip.id}>
            <div className="media">
              <div className="media-body mt-0-5">
                <h5 className="media-heading mb-4">
                  <b>{initialData.booking_id}: {trip.booking_id}</b> <span>{!(['ACCEPTED', 'PICKEDUP', 'DROPPED'].includes(trip.status)) && initialData.edit_permission == 1 &&
                  <a
                    className="btn btn-danger pull-right"
                    href={"/admin/dispatcher/cancel?request_id=" + trip.id}
                  >
                    {initialData.cancel_ride}
                  </a>
                }
                  {(['SEARCHING', 'REQUESTED'].includes(trip.status) || (trip.status == "SCHEDULED" && trip.provider_id == "0")) && initialData.edit_permission == 1 &&
                    <a
                      className="btn btn-info pull-right mr-0-75"
                      key={trip.id}
                      onClick={this.handleClick.bind(this, trip)}
                      href="javascript:;"
                    >
                      {initialData.assign_driver}
                    </a>
                  }
                </span></h5>
                <hr />
                {trip.status == "COMPLETED" ? (
                  <span className="tag tag-success pull-right">
                    {" "}
                    {initialData[`${trip.status.toLowerCase()}`]}{" "}
                  </span>
                ) : trip.status == "CANCELLED" ? (
                  <span className="tag tag-danger pull-right">
                    {" "}
                    {initialData[`${trip.status.toLowerCase()}`]}{" "}
                  </span>
                ) : trip.status == "SEARCHING" ? (
                  <span className="tag tag-warning pull-right">
                    {" "}
                    {initialData[`${trip.status.toLowerCase()}`]}{" "}
                  </span>
                ) : trip.status == "SCHEDULED" && trip.provider_id == "0" ? (
                  <span className="tag tag-primary pull-right">
                    {" "}
                    {initialData[`${trip.status.toLowerCase()}`]}{" "} | {initialData.pending}
                  </span>
                ) : trip.status == "SCHEDULED" ? (
                  <span className="tag tag-primary pull-right">
                    {" "}
                    {initialData[`${trip.status.toLowerCase()}`]}{" "}
                  </span>
                ) : trip.status == "REQUESTED" && trip.provider_id == "0" ? (
                  <span className="tag tag-primary pull-right">
                    {" "}
                    {initialData[`${trip.status.toLowerCase()}`]}{" "} | {initialData.pending}
                  </span>
                ) : trip.status == "REQUESTED" ? (
                  <span className="tag tag-primary pull-right">
                    {" "}
                    {initialData[`${trip.status.toLowerCase()}`]}{" "} | {initialData.pending}
                  </span>
                ) : (
                  <span className="tag tag-info pull-right">
                    {" "}
                    {initialData[`${trip.status.toLowerCase()}`]}{" "}
                  </span>
                )}
                {
                  trip.user && 
                  <div className='user_info__wrapper'>
                    <img
                      className="user_info__img" style={{ "height": "40px", "width": "40px", "borderRadius": "2rem" }}
                      src={'/storage/' + trip.user.picture || '/asset/img/default-avatar.png'}
                      onError={(e) => {
                        e.target.src = '/asset/img/default-avatar.png'
                      }} />
                    <h5><b>{initialData.user}</b><br />
                      {trip.user ? trip.user.first_name : "N/A"}{" "}
                      {trip.user ? trip.user.last_name : "N/A"} {" "} {trip.user ? trip.user.mobile : "N/A"} {" "} <a href={"https://api.whatsapp.com/send?phone=" + (trip.user ?  trip.user.mobile.replace(/[+]/g, '') : "")} target="_blank"><i className="fab fa-whatsapp mr-0-75 ml-0-75" style={{ "fontSize": "25px", "color": "#3e70c9" }}></i></a><a href={"tel:" + (trip.user ?  trip.user.mobile.replace(/[+]/g, '') : "")} target="_blank"><i className="fas fa-phone-alt" style={{ "fontSize": "20px", "color": "#3e70c9" }}></i></a></h5>
                  </div>
                }
                <hr />
                {(['ACCEPTED', 'STARTED', 'ARRIVED', 'PICKEDUP', 'DROPPED'].includes(trip.status) || (['SCHEDULED'].includes(trip.status) && trip.provider_id != "0" && trip.provider)) &&
                  <div className='user_info__wrapper justify-content-between w-100'>
                    <div className="d-flex justify-content-between" style={{ gap: '.4rem' }}>
                      <img
                        className="user_info__img" style={{ "height": "40px", "width": "40px", "borderRadius": "2rem" }}
                        src={'/storage/' + (trip.provider ? trip.provider.avatar : '/asset/img/default-avatar.png')}
                        onError={(e) => {
                          e.target.src = '/asset/img/default-avatar.png'
                        }} />
                      <h5><b>{initialData.driver}</b><br />
                        {trip.provider ? trip.provider.first_name : "N/A"}{" "}
                        {trip.provider ? trip.provider.last_name : "N/A"} {" "} {trip.provider ? trip.provider.mobile : "N/A"} {" "} <a href={"https://api.whatsapp.com/send?phone=" + (trip.provider ?  trip.provider.mobile.replace(/[+]/g, '') : "")} target="_blank"><i className="fab fa-whatsapp mr-0-75 ml-0-75" style={{ "fontSize": "25px", "color": "#3e70c9" }}></i></a><a href={"tel:" + (trip.provider ?  trip.provider.mobile.replace(/[+]/g, '') : "")} target="_blank"><i className="fas fa-phone-alt" style={{ "fontSize": "20px", "color": "#3e70c9" }}></i></a></h5>
                    </div>
                    {['ACCEPTED', 'ASSIGNED', 'SCHEDULED'].includes(trip.status) && initialData.edit_permission == 1  && <button className="btn btn-success pull-right" onClick={this.handleClick.bind(this, trip)}>{initialData.change_driver}</button>}
                  </div>
                }
                {(['ACCEPTED', 'STARTED', 'ARRIVED', 'PICKEDUP', 'DROPPED'].includes(trip.status) || (['SCHEDULED'].includes(trip.status) && trip.provider_id != "0")) &&
                  <hr />
                }

                <h6 className="media-heading"><b>{initialData.from}:</b> {trip.s_address}</h6>
                <h6 className="media-heading">
                  <b>{initialData.to}</b>: {trip.d_address ? trip.d_address : "Not Selected"}
                </h6>
                <h6 className="media-heading"><b>{initialData.payment}</b>: {trip.payment_mode}</h6>
                <h6 className="media-heading"><b>{initialData.amount}</b>: {trip.formatted_amount}</h6>
                <h6 className="media-heading"><b>{initialData.distance}</b>: {trip.formatted_distance}</h6>

                {show_otp && <h6 className="media-heading"><b>{initialData.otp}</b>: {trip.otp}</h6>}
                <h6 className="media-heading"><b>{initialData.type}: {trip.service_type ? trip.service_type.name : 'N/A'}</b></h6>
                {trip.specialNote && <h6 className="media-heading"><b>{initialData.notes}</b>: {trip.specialNote}</h6>}

                {trip.status === 'SCHEDULED' &&
                  <div style={{ display: "flex", justifyContent: "space-between", alignItems: "center" }}>
                    <h6 className="media-heading"><b>{initialData.schedule}</b>: {trip.schedule_at}</h6>
                    {['ACCEPTED', 'ASSIGNED', 'SCHEDULED'].includes(trip.status) && initialData.edit_permission == 1  && <a href={`/admin/dispatcher/${trip.id}/update-schedule`} className="btn update-schedule-btn">{initialData.update_schedule}</a>}
                  </div>
                }
                <progress
                  className="progress progress-success progress-sm"
                  max="100"
                ></progress>
                <span className="text-muted">
                  {trip.current_provider_id == 0
                    ? initialData.assign_date
                    : initialData.requested_date} {" "}
                  : {trip.created_at}
                </span>
              </div>
            </div>
        </div>
      );
    }.bind(this);

    return (
      <div className="items-list">
        {trips.data && trips.data.map(listItem)}
      </div>
    );
  }
}

class DispatcherRequest extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      data: [],
    };
  }

  componentDidMount() {
    var mobile = $("#mobile");

    // initialise plugin
    mobile.intlTelInput({
      allowExtensions: true,
      formatOnDisplay: true,
      autoFormat: true,
      autoHideDialCode: true,
      autoPlaceholder: true,
      defaultCountry: "auto",
      ipinfoToken: "yolo",
      nationalMode: false,
      numberType: "MOBILE",
      // onlyCountries: ['bn', 'us', 'gb', 'ch', 'ca', 'do','pk'],
      // preferredCountries: ['sa', 'ae', 'qa','om','bh','kw','ma', 'pk'],
      preventInvalidNumbers: true,
      separateDialCode: false,
      initialCountry: "auto",
      geoIpLookup: function (callback) {
        $.get(
          "https://ipinfo.io?token=ee8a1ac0f823c9",
          function () { },
          "jsonp"
        ).always(function (resp) {
          var countryCode = resp && resp.country ? resp.country : "";
          callback(countryCode);
        });
      },
      utilsScript:
        "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js",
    });

    var reset = function () {
      mobile.removeClass("error");
      // errorMsg.addClass("hide");
      // validMsg.addClass("hide");
    };

    // on blur: validate
    mobile.blur(function () {
      reset();
      if ($.trim(mobile.val())) {
        if (mobile.intlTelInput("isValidNumber")) {
          // validMsg.removeClass("hide");
        } else {
          mobile.addClass("error");
          // errorMsg.removeClass("hide");
        }
      }
    });

    // on keyup / change flag: reset
    mobile.on("keyup change", reset);

    // Auto Assign Switch
    new Switchery(document.getElementById("provider_auto_assign"));

    // Schedule Time Datepicker
    $("#schedule_time").datetimepicker({
      minDate: window.Tranxit.minDate,
      // maxDate: window.Tranxit.maxDate,
    });

    // Get Service Type List
    $.get(
      "/admin/service",
      function (result) {
        this.setState({
          data: result,
        });
      }.bind(this)
    );

    // Mount Ride Create Map

    window.createRideInitialize();

    function stopRKey(evt) {
      var evt = evt ? evt : event ? event : null;
      var node = evt.target
        ? evt.target
        : evt.srcElement
          ? evt.srcElement
          : null;
      if (evt.keyCode == 13 && node.type == "text") {
        return false;
      }
    }

    document.onkeypress = stopRKey;
  }

  createRide(event) {
    // console.log(event);
    event.preventDefault();
    event.stopPropagation();
    // console.log("Hello", $("#form-create-ride").serialize());

    var originInput = document.getElementById("s_address").value;
    var destinationInput = document.getElementById("d_address").value;

    if (originInput == destinationInput) {
      alert(this.props.initialData.source_and_destination_address_should_not_be_same);
      return false;
    }

    $.ajax({
      url: "/admin/dispatcher",
      dataType: "json",
      headers: { "X-CSRF-TOKEN": window.Laravel.csrfToken },
      type: "POST",
      data: $("#form-create-ride").serialize(),
      success: function (data) {
        if(!data)
          document.getElementById('request_already_message').style.display = 'block';
        
        this.props.completed(data);
      }.bind(this),
    });
  }

  fetchData() {
    var mobile = $("#mobile").val();
    $.ajax({
      url: "fetch-user",
      dataType: "json",
      headers: { "X-CSRF-TOKEN": window.Laravel.csrfToken },
      type: "POST",
      data: { mobile: mobile },
      success: function (data) {
        if (data !== "false") {
          // console.log(data);
          $("#first_name").val(data.first_name);
          $("#last_name").val(data.last_name);
          $("#email").val(data.email);
        } else {
          $("#first_name").val("");
          $("#last_name").val("");
          $("#email").val("");
        }
      },
    });
  }

  scheduleField() {
    var schedule_fields = document.getElementById('schedule_fields');
    if (schedule_fields.style.display == 'none') {
      schedule_fields.style.display = 'block';
    } else {
      schedule_fields.style.display = 'none';
    }

  }

  cancelCreate() {
    this.props.cancel(true);
  }

  render() {
    return (
      <div className="card card-block" id="create-ride">
        <h3 className="card-title text-uppercase">{this.props.initialData.ride_details}</h3>
        <form
          id="form-create-ride"
          onSubmit={this.createRide.bind(this)}
          method="POST"
        >
          <div className="row">
            <div className="col-xs-6">
              <div className="form-group">
                <label htmlFor="mobile">{this.props.initialData.phone}</label>
                <input
                  type="text"
                  onChange={this.fetchData.bind(this)}
                  className="form-control"
                  name="mobile"
                  id="mobile" minlength="10" maxlength="15"
                  placeholder={this.props.initialData.phone}
                  required
                />
              </div>
            </div>
            <div className="col-xs-6">
              <div className="form-group">
                <label htmlFor="first_name">{this.props.initialData.first_name}</label>
                <input
                  type="text"
                  className="form-control"
                  name="first_name"
                  id="first_name"
                  placeholder={this.props.initialData.first_name}
                  required
                />
              </div>
            </div>
            <div className="col-xs-6">
              <div className="form-group">
                <label htmlFor="last_name">{this.props.initialData.last_name}</label>
                <input
                  type="text"
                  className="form-control"
                  name="last_name"
                  id="last_name"
                  placeholder={this.props.initialData.last_name}
                  required
                />
              </div>
            </div>
            <div className="col-xs-6">
              <div className="form-group">
                <label htmlFor="email">{this.props.initialData.email}</label>
                <input
                  type="email"
                  className="form-control"
                  name="email"
                  id="email"
                  placeholder={this.props.initialData.email}
                  required
                />
              </div>
            </div>

            <div className="col-xs-12">
              <div className="form-group">
                <label htmlFor="s_address">{this.props.initialData.pickup_address}</label>

                <input
                  type="text"
                  name="s_address"
                  className="form-control"
                  id="s_address"
                  placeholder={this.props.initialData.pickup_address}
                  required
                ></input>

                <input type="hidden" name="s_latitude" id="s_latitude"></input>
                <input
                  type="hidden"
                  name="s_longitude"
                  id="s_longitude"
                ></input>
              </div>
              <div className="form-group">
                <label htmlFor="d_address">{this.props.initialData.dropoff_address}</label>

                <input
                  type="text"
                  name="d_address"
                  className="form-control"
                  id="d_address"
                  placeholder={this.props.initialData.dropoff_address}
                  required
                ></input>

                <input type="hidden" name="d_latitude" id="d_latitude"></input>
                <input
                  type="hidden"
                  name="d_longitude"
                  id="d_longitude"
                ></input>
                <input type="hidden" name="distance" id="distance"></input>
              </div>
              <div className="form-group">
                <label htmlFor="schedule_time">{this.props.initialData.schedule}: </label>&nbsp;
                <input name="schedule" type="checkbox" className="js-switch" onChange={this.scheduleField.bind(this)}></input>
              </div>

              <div id="schedule_fields" className="form-group" style={{ display: "none" }}>
                <label htmlFor="schedule_time">{this.props.initialData.schedule_date_time}</label>
                <input
                  type="text"
                  className="form-control"
                  name="schedule_time"
                  id="schedule_time"
                  placeholder="Date"
                  autocomplete="off"
                />
              </div>
              <div id="schedule_fields" className="form-group">
                <label htmlFor="schedule_time">{this.props.initialData.special_note}</label>
                <textarea name="specialNote" className="form-control" id="special_note"
                  placeholder={this.props.initialData.please_enter_any_extra_details_here}></textarea>
              </div>
               <div id="request_category_fields" className="form-group">
                <label htmlFor="request_category">{this.props.initialData.request_category}</label>
                <select name="request_category" id="request_category" className="form-control" required>
                  <option value="Normal" selected>{this.props.initialData.normal}</option>
                  <option value="Metered">{this.props.initialData.metered}</option>
                </select>
              </div>
              <div className="form-group">
                <label htmlFor="service_types">{this.props.initialData.service_type}</label>
                <ServiceTypes data={this.state.data} />
              </div>
              <div className="form-group">
                <label htmlFor="provider_auto_assign">
                  {this.props.initialData.auto_assign_driver}
                </label>
                <br />
                <input
                  type="checkbox"
                  id="provider_auto_assign"
                  name="provider_auto_assign"
                  className="js-switch"
                  data-color="#f59345"
                  defaultCheckedDisable
                />
              </div>
            </div>
          </div>
          <div className="row">
            <div className="col-xs-6">
              <button
                type="button"
                className="btn btn-lg btn-danger btn-block waves-effect waves-light"
                onClick={this.cancelCreate.bind(this)}
              >
                {this.props.initialData.cancel}
              </button>
            </div>
            <div className="col-xs-6">
              <button className="btn btn-lg btn-success btn-block waves-effect waves-light">
                {this.props.initialData.submit}
              </button>
            </div>
          </div>
        </form>
      </div>
    );
  }
}

class DispatcherAssignList extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      data: {
        data: [],
      },
    };
  }

  componentDidMount() {
    this.getProviders();
  }

  componentDidUpdate(prevProps) {
    if (prevProps.searchTerm === this.props.searchTerm)
      return;

    this.getProviders();
  }

  getProviders() {
    const q = this.props.searchTerm;
    const queryParams = {
      latitude: this.props.trip.s_latitude,
      longitude: this.props.trip.s_longitude,
      service_type: this.props.trip.service_type_id
    }
    if (q) {
      queryParams['q'] = q;
    }

    const currentProvider = this.props.trip.provider_id;
    if (currentProvider)
      queryParams['current_provider'] = currentProvider;


    $.get(
      "/admin/dispatcher/providers",
      queryParams,
      function (result) {
        if (result.hasOwnProperty("data")) {
          this.setState({
            data: result,
          });
          window.assignProviderShow(result.data, this.props.trip);
        } else {
          this.setState({
            data: {
              data: [],
            },
          });
          window.providerMarkersClear();
        }
      }.bind(this)
    );
  }

  render() {
    // console.log("DispatcherAssignList - render", this.state.data);
    return (
      <div className="card h-100" style={{ marginBottom: '0' }}>
        <div className="card-header text-uppercase">
          <b>{this.props.initialData.assign_driver}</b>
        </div>

        <DispatcherAssignListItem
          initialData={this.props.initialData}
          data={this.state.data.data}
          trip={this.props.trip}
        />
      </div>
    );
  }
}

class DispatcherAssignListItem extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      data: [],
    };
  }
  handleClick(provider) {
    // this.props.clicked(trip);
    // console.log("Provider Clicked");
    window.assignProviderPopPicked(provider.service[0].id);
  }

  render() {
    var listItem = function (provider, index) {
      return (
        <div
          className="il-item"
          key={index}
          onClick={this.handleClick.bind(this, provider)}
        >
          <a className="text-black" href="#">
            <div className="media">
              <div className="media-body">
                <p className="mb-0-5 user_info__wrapper">
                  <img
                    className="user_info__img" style={{ "height": "40px", "width": "40px", "borderRadius": "2rem" }}
                    src={'/storage/' + provider.avatar || '/asset/img/default-avatar.png'}
                    onError={(e) => {
                      e.target.src = '/asset/img/default-avatar.png'
                    }} />
                  {provider.first_name} {provider.last_name}
                </p>
                <span className={`tag pull-right ${provider.service[0] && provider.service[0].status === 'active' ? 'tag-success' : 'tag-danger'}`}>
                  {provider.service[0] && provider.service[0].status}
                </span>
                <h6 className="media-heading">{this.props.initialData.rating}: {provider.rating}</h6>
                <h6 className="media-heading">{this.props.initialData.phone}: {provider.mobile}</h6>
                <h6 className="media-heading">
                  {this.props.initialData.type}: {provider.service[0] && provider.service[0].service_type ? provider.service[0].service_type.name : 'N/A'}
                </h6>
                <h6 className="media-heading">
                  {this.props.initialData.car_model}: {provider.service[0] ? provider.service[0].service_model : 'N/A'}
                </h6>
                <h6 className="media-heading">
                  {this.props.initialData.car_number}: {provider.service[0] ? provider.service[0].service_number : 'N/A'}
                </h6>
              </div>
            </div>
          </a>
        </div>
      );
    }.bind(this);

    return <div className="items-list">{this.props.data.map(listItem)}</div>;
  }
}

class ServiceTypes extends React.Component {
  render() {
    // console.log('ServiceTypes', this.props.data);
    var mySelectOptions = function (result) {
      return (
        <ServiceTypesOption key={result.id} id={result.id} name={result.name} />
      );
    };
    return (
      <select name="service_type" className="form-control">
        {this.props.data.map(mySelectOptions)}
      </select>
    );
  }
}

class ServiceTypesOption extends React.Component {
  render() {
    return <option value={this.props.id}>{this.props.name}</option>;
  }
}

class DispatcherMap extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      data: [],
    };
  }
  render() {
    return (
      <div className="card my-card h-100">
        <div className="card-header text-uppercase">
          <b>{this.props.initialData.map}</b>
        </div>
        <div className="card-body">
          <div id="map" ></div>
          {/* <div id="legend">
            <h3>Note: </h3>
          </div> */}
        </div>
      </div>
    );
  }
}
const initialData = window.__INITIAL_DATA__ || {};
ReactDOM.render(
  <DispatcherPanel initialData={initialData}/>,
  document.getElementById("dispatcher-panel")
);