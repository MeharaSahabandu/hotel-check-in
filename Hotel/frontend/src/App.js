import "./App.css";
import "primereact/resources/themes/lara-light-indigo/theme.css";
import "primereact/resources/primereact.min.css";
import "primeicons/primeicons.css";
import { Button } from "primereact/button";
import { Dialog } from "primereact/dialog";
import axios from "axios";
import "./styles.css";
import { DataTable } from "primereact/datatable";
import { Column } from "primereact/column";
import { useState, useEffect } from "react";
import { InputText } from "primereact/inputtext";
import { Dropdown } from "primereact/dropdown";
import { Calendar } from "primereact/calendar";
import Header from "./components/Header";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

export default function App() {
  const [roomNo, setRoomNo] = useState(null);
  const [selectedStayType, setSelectedStayType] = useState(null);
  const [selectedSuite, setSelectedSuite] = useState(null);
  const [data, setData] = useState([]);
  const [visible, setVisible] = useState(false);
  const [initialdata, setInitialdata] = useState([]);
  const [startDate, setStartDate] = useState(null);
  const [endDate, setEndDate] = useState(null);
  const [price, setPrice] = useState(null);
  const [bookingPrice, setBookingPrice] = useState(null);
  const [taxPrice, setTaxPrice] = useState(null);
  const [info, setinfo] = useState([]);
  const [nic, setNic] = useState(null);
  const [contact, setContact] = useState(null);
  const [name, setName] = useState(null);

  const namechan = (e) => {
    setName(e.target.value);
  };
  const nicchan = (e) => {
    setNic(e.target.value);
  };
  const contactchan = (e) => {
    setContact(e.target.value);
  };
  console.log(name);
  console.log(nic);
  console.log(contact);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get(
          "http://127.0.0.1:8000/api/currentStatus"
        );
        console.log(response.data);
        setInitialdata(response.data);
        setData(response.data);
      } catch (error) {
        console.error(error);
      }
    };
    fetchData();
  }, []);

  useEffect(() => {
    if (selectedSuite) {
      const fetcher = async () => {
        const { name } = selectedSuite;
        const aa = name.toLowerCase();
        const resp = await axios.get(
          `http://127.0.0.1:8000/api/sortedAvailableRooms/${aa}`
        );
        setinfo(resp.data[0]);
        console.log(resp.data[0]);
      };
      fetcher();
    }
  }, [selectedSuite]);

  useEffect(() => {
    if (startDate && endDate && selectedStayType && selectedSuite && roomNo) {
      setPrice(true);
      let noOfDays = endDate.getTime() - startDate.getTime();
      let totalDays = Math.ceil(noOfDays / (1000 * 360 * 24));
      console.log(noOfDays);
      console.log(totalDays);
      let packagePrice = 0;

      const { name: types } = selectedStayType;
      const { name: ss } = selectedSuite;
      console.log(ss);
      if (types === "FB" && ss === "Deluxe") {
        packagePrice = 40000;
      }
      if (types === "BB" && ss === "Deluxe") {
        packagePrice = 20000;
      }
      if (types === "FB" && ss === "Standard") {
        packagePrice = 40000;
      }
      if (types === "BB" && ss === "Standard") {
        packagePrice = 20000;
      }

      const total = packagePrice * totalDays;
      const taxPrice = total * 0.1;
      setBookingPrice(total);
      setTaxPrice(taxPrice);
    }
  }, [startDate, endDate, selectedStayType, roomNo, selectedSuite]);

  const onHide = () => {
    setVisible(false);
  };

  const stay = [{ name: "FB" }, { name: "BB" }];

  const suite = [{ name: "Standard" }, { name: "Deluxe" }];

  const room = info.map((room) => {
    return { name: room };
  });

  const submit = async (e) => {
    const date = new Date(startDate);
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const day = String(date.getDate()).padStart(2, "0");
    const hours = String(date.getHours()).padStart(2, "0");
    const minutes = String(date.getMinutes()).padStart(2, "0");
    const seconds = String(date.getSeconds()).padStart(2, "0");
    const check_in = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    console.log(check_in);

    const enddate = new Date(endDate);
    const endyear = enddate.getFullYear();
    const endmonth = String(enddate.getMonth() + 1).padStart(2, "0");
    const endday = String(enddate.getDate()).padStart(2, "0");
    const endhours = String(enddate.getHours()).padStart(2, "0");
    const endminutes = String(enddate.getMinutes()).padStart(2, "0");
    const endseconds = String(enddate.getSeconds()).padStart(2, "0");
    const check_out = `${endyear}-${endmonth}-${endday} ${endhours}:${endminutes}:${endseconds}`;
    console.log(check_out);

    const { name: staytype } = stay;
    const { name: suiteName } = suite;
    const { name: roomNum } = room;
    console.log(name);

    const response = await axios.post(`http://127.0.0.1:8000/api/addBooking`, {
      name: name,
      nic: nic,
      contact: contact,
      check_in: check_in,
      check_out: check_out,
      stay_type: staytype,
      suite: suiteName,
      room_id: roomNum,
    });
    console.log(response);
    toast.warn("check in successfully");
  };

  const search = (e) => {
    const value = e.target.value;
    const search_result = initialdata.filter((item) => {
      if (item.id.toString().startsWith(value)) {
        return item;
      }
      if (item.name) {
        if (
          item.name.toLowerCase().startsWith(value) ||
          item.nic.toString().startsWith(value) ||
          item.contact.toString().startsWith(value)
        ) {
          return item;
        }
      }
      if (!value) {
        return item;
      }
    });
    setData(search_result);
  };

  return (
    <div>
      <Header />
      <div style={{ display: "flex", alignItems: "center" }}>
        <div>
          <div
            className="newButtonAndTopicAndSearch"
            style={{ display: "flex" }}
          >
            <div className="inside">
              <div className="check-in">Check-In List</div>
              <Button label="New Check-In" onClick={() => setVisible(true)} />
            </div>
            <div className="search">
              <span className="p-input-icon-left">
                <i className="pi pi-search" />
                <InputText placeholder="Search" onChange={search} />
              </span>
            </div>
          </div>

          <Dialog
            header="Add New Check-In"
            visible={visible}
            style={{ width: "50vw" }}
            onHide={() => setVisible(false)}
          >
            <form>
              <div>
                <p>Guest Information</p>
                <br></br>

                <div style={{ display: "flex" }}>
                  <div style={{ display: "inline-block", marginRight: "1rem" }}>
                    <label htmlFor="name">Name</label>
                    <br />
                    <InputText
                      onChange={namechan}
                      id="name"
                      aria-describedby="username-help"
                    />
                  </div>
                  <div style={{ display: "inline-block", marginRight: "1rem" }}>
                    <label htmlFor="nic">NIC</label>
                    <br />
                    <InputText
                      id="nic"
                      onChange={nicchan}
                      aria-describedby="username-help"
                    />
                  </div>
                  <div style={{ display: "inline-block" }}>
                    <label htmlFor="contact">Contact Number</label>
                    <br />
                    <InputText
                      id="contact"
                      onChange={contactchan}
                      aria-describedby="username-help"
                    />
                  </div>
                </div>

                <br></br>

                <p>Check-In Details</p>
                <br></br>
                <div style={{ display: "flex" }}>
                  <div style={{ display: "inline-block", marginRight: "1rem" }}>
                    <label htmlFor="staying_period">Staying Period</label>
                    <br />
                    <Calendar
                      value={startDate}
                      showTime={true}
                      onChange={(e) => setStartDate(e.value)}
                    />
                  </div>
                  <div style={{ display: "inline-block", marginRight: "1rem" }}>
                    <label htmlFor="endDate"></label>
                    <br />
                    <Calendar
                      value={endDate}
                      showTime={true}
                      onChange={(e) => setEndDate(e.value)}
                    />
                  </div>
                  <div style={{ display: "inline-block", marginRight: "1rem" }}>
                    <label htmlFor="stayType">Stay Type</label>
                    <br />
                    <Dropdown
                      value={selectedStayType}
                      onChange={(e) => setSelectedStayType(e.value)}
                      options={stay}
                      optionLabel="name"
                      placeholder="Select"
                      className="w-full md:w-14rem"
                    />
                  </div>
                </div>
                <br />
                <div style={{ display: "inline-block", marginRight: "1rem" }}>
                  <label htmlFor="suite">Room Suite</label>
                  <br />
                  <Dropdown
                    value={selectedSuite}
                    onChange={(e) => setSelectedSuite(e.value)}
                    options={suite}
                    optionLabel="name"
                    placeholder="Select"
                    className="w-full md:w-14rem"
                  />
                </div>
                <div style={{ display: "inline-block", marginRight: "1rem" }}>
                  <label htmlFor="roomNo">Room No</label>
                  <br />
                  <Dropdown
                    value={roomNo}
                    onChange={(e) => setRoomNo(e.value)}
                    options={room}
                    optionLabel="name"
                    placeholder="Select"
                    className="w-full md:w-14rem"
                  />
                </div>
              </div>
              <br></br>
              {price && (
                <div className="charges">
                  <div className="charges-container">
                    <div className="single-row-payment">
                      <span>Subtotal</span>
                      <span className="end">{bookingPrice}</span>
                    </div>
                    <div className="single-row-payment">
                      <span>Tax 10%</span>
                      <span className="end">{taxPrice}</span>
                    </div>
                    <div className="single-row-payment">
                      <span>Total</span>
                      <span className="end">LKR{bookingPrice + taxPrice}</span>
                    </div>
                  </div>
                </div>
              )}
            </form>
            <br></br>
            <hr></hr>
            <br></br>
            <div style={{ display: "flex", justifyContent: "flex-end" }}>
              <br></br>
              <Button onClick={submit} label="Check-In" />
            </div>
          </Dialog>
        </div>
      </div>
      <DataTable
        value={data}
        paginator
        rows={8}
        tableStyle={{ minWidth: "50rem" }}
      >
        <Column
          field="id"
          sortable
          header="Room ID"
          style={{ width: "8%" }}
        ></Column>
        <Column
          field="status"
          sortable
          header="Status"
          style={{ width: "8%" }}
        ></Column>
        <Column
          field="suite"
          sortable
          header="Room Suite"
          style={{ width: "8%" }}
        ></Column>
        <Column field="name" header="Guest" style={{ width: "10%" }}></Column>
        <Column
          field="check_in"
          header="Staying Period"
          style={{ width: "12.5%" }}
        ></Column>
        <Column
          field="stay_type"
          sortable
          header="Stay Type"
          style={{ width: "8%" }}
        ></Column>
        <Column
          field="contact"
          header="Contact"
          style={{ width: "10%" }}
        ></Column>
        <Column field="nic" header="NIC" style={{ width: "8%" }}></Column>
      </DataTable>
    </div>
  );
}
