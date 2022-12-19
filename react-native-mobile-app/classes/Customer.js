
import React, { Component } from "react";
import {
  StyleSheet,
  TouchableOpacity,
  View,
  Text,
  TextInput,
  Pressable
} from 'react-native';
import { connect } from 'react-redux';
import CustomerContext from '../context/CustomerContext'
import { signup_url, login_url, update_url } from '../API.js'

import { showMessage, hideMessage } from "react-native-flash-message";


class Customer extends Component {
  static contextType = CustomerContext
  constructor() {
    super();
    this.state = {
      form: 0,
      name: '',
      email: '',
      phone: '',
      password: '',
      houseNo: '',
      street: '',
      city: ''

    };
  }


  async signUp() {

    let formData = new FormData();
    formData.append('name', this.state.name);
    formData.append('email', this.state.email);
    formData.append('phone', this.state.phone);
    formData.append('password', this.state.password);

    fetch(signup_url, {
      method: 'POST',
      body: formData,
    }).then(response => response.json())
      .then(data => {
        console.log(data, 'laravel')

        if (data?.access_token) {
          this.props.setToken(data.access_token);
          this.props.forceUpdateParent();
        } else {
          console.log(data)
          showMessage({
            message: data.message,
            type: data.type,
          });
        }
      })
  }



  signIn() {
    let formData = new FormData();
    formData.append('email', this.state.email);
    formData.append('password', this.state.password);
    console.log(this.state.email, this.state.password)
    fetch(login_url, {
      method: 'POST',
      body: formData,
    }).then(response => response.json())
      .then(data => {
        console.log(data, 'laravel')

        if (data?.access_token) {
          this.props.setToken(data.access_token);
          this.props.forceUpdateParent();
        } else {
          showMessage({
            message: data.message,
            type: data.type,
          });
        }
      })
  }

  updateProfile() {
    let formData = new FormData();
    formData.append('name', this.state.name);
    formData.append('email', this.state.email);
    formData.append('phone', this.state.phone);
    formData.append('password', this.state.password);
    formData.append('houseNo', this.state.houseNo);
    formData.append('street', this.state.street);
    formData.append('city', this.state.city);


    console.log(this.props, 'update props')
    fetch(update_url, {
      method: 'POST',
      body: formData,
      headers: new Headers({
        'Authorization': 'Bearer ' + this.props.token
      }),
    }).then(response => response.json())
      .then(data => {
        console.log(data, 'laravel')

        if (data.type == 'success') {

          if (data.reset) {
            this.setState({ form: 1 })
            this.props.setToken(null);
            this.context()
            console.log(data, 'data')
          }

        }
        showMessage({
          message: data.message,
          type: data.type,
        });
      })
  }

  render() {


    if (!this.props.token) {
      if (this.state.form == 0) {
        return (

          <View
            style={{
              flex: 1,
              alignItems: 'center',
              justifyContent: 'center',
              flexDirection: 'column',
              backgroundColor: '#fff'
            }}
          >

            <Text style={styles.heading}>
              Sign Up
            </Text>
            <TextInput
              style={styles.input}
              placeholder="Name"
              onChangeText={(text) => this.setState({ name: text })}
            />

            <TextInput
              style={styles.input}
              placeholder="Email"
              onChangeText={(text) => this.setState({ email: text })}
            />

            <TextInput
              style={styles.input}
              keyboardType='numeric'
              placeholder="Phone"
              onChangeText={(text) => this.setState({ phone: text })}
            />


            <TextInput
              style={styles.input}
              placeholder="Password"
              secureTextEntry={true}
              onChangeText={(text) => this.setState({ password: text })}
            />
            <Pressable
              onPress={() => this.signUp()}
              style={styles.button}
            >
              <Text style={styles.button_text}>Sign Up</Text>
            </Pressable>

            <TouchableOpacity onPress={() => this.setState({ form: 1 })}>
              <Text style={styles.optext}>Have an account? Log in.</Text>
            </TouchableOpacity>
          </View>

        );
      } else if (this.state.form == 1) {
        return (
          <View
            style={{
              flex: 1,
              alignItems: 'center',
              justifyContent: 'center',
              flexDirection: 'column',
              backgroundColor: '#fff'
            }}
          >

            <Text style={styles.heading}>
              Sign In
            </Text>
            <TextInput
              style={styles.input}
              placeholder="Email"
              onChangeText={(text) => this.setState({ email: text })}
            />

            <TextInput
              style={styles.input}
              placeholder="Password"
              secureTextEntry={true}
              onChangeText={(text) => this.setState({ password: text })}
            />
            <Pressable
              onPress={() => this.signIn()}
              style={styles.button}
            >
              <Text style={styles.button_text}>Sign In</Text>
            </Pressable>

            <TouchableOpacity onPress={() => this.setState({ form: 0 })}>
              <Text style={styles.optext}>Need an account? Sign up.</Text>
            </TouchableOpacity>
          </View>

        )
      }
    } else {
      return (

        <View
          style={{
            flex: 1,
            alignItems: 'center',
            justifyContent: 'center',
            flexDirection: 'column',
            backgroundColor: '#fff'
          }}
        >

          <Text style={styles.heading}>
            Update Profile
          </Text>

          <TextInput
            style={styles.input}
            placeholder="Name"
            onChangeText={(name) => this.setState({ name: name })}
          />


          <TextInput
            style={styles.input}
            placeholder="Email"
            onChangeText={(email) => this.setState({ email: email })}
          />

          <TextInput
            style={styles.input}
            placeholder="Phone"
            onChangeText={(phone) => this.setState({ phone: phone })}
          />

          <TextInput
            style={styles.input}
            placeholder="Password"
            secureTextEntry={true}
            onChangeText={(password) => this.setState({ password: password })}
          />

          <TextInput
            style={styles.input}
            placeholder="House"
            onChangeText={(houseNo) => this.setState({ houseNo: houseNo })}
          />


          <TextInput
            style={styles.input}
            placeholder="Street"
            onChangeText={(street) => this.setState({ street: street })}
          />


          <TextInput
            style={styles.input}
            placeholder="City"
            onChangeText={(city) => this.setState({ city: city })}
          />

          <Pressable
            onPress={() => this.updateProfile()}
            style={styles.button}
          >
            <Text style={styles.button_text}>Update</Text>
          </Pressable>

        </View>

      );
    }
  }
}

const styles = StyleSheet.create({
  input: {
    height: 50,
    margin: 12,
    borderWidth: 1,
    width: "90%",
    borderRadius: 50,
    borderColor: "#dbdbdb",
    padding: 10,
    backgroundColor: "#fff"
  },
  heading: {
    fontSize: 20,
    fontWeight: 'bold'
  },
  optext: {
    fontSize: 14,
    fontWeight: 'bold',
    paddingTop: 10
  },
  button: {
    backgroundColor: "#f5c505",
    padding: 10,
    width: "60%",
    marginBottom: 20,
    borderRadius: 20
  },
  button_text: {
    textAlign: 'center',
    color: "#fff",
    fontWeight: 'bold'
  },
});



function mapStateToProps(state) {
  return {
    token: state.token
  }
}

function mapDispatchToProps(dispatch) {
  return {
    setToken: (token) => dispatch({ type: 'SETTOKEN', token: token }),
  }
}


export default connect(mapStateToProps, mapDispatchToProps)(Customer)