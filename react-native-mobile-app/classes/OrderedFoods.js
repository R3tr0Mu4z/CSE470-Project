
import React, { Component } from "react";
import {
  ScrollView,
  StyleSheet,
  TouchableOpacity,
  View,
  Text,
  RefreshControl,
} from 'react-native';
import { connect } from 'react-redux';
import OrderedFood from "./OrderedFood.js";
import { orders_url } from '../API.js'


class OrderedFoods extends Component {
  constructor(props) {
    super();
    this.state = {
      ordered_foods: [],
      refreshing: false
    };
  }

  componentDidMount() {
    console.log(orders_url + this.props.token, "orders_url+this.props.token")
    this.getOrders()
  }

  getOrders() {
    fetch(orders_url, {
      method: 'GET',
      headers: new Headers({
        'Authorization': 'Bearer ' + this.props.token
      })
    }).then(response => response.json())
      .then(response => {
        this.setState({ ordered_foods: response, refreshing: false })
      })
  }

  viewOrderedItemDetails(order) {
    this.props.navigation.navigate('Order', {
      order: order
    })
  }

  listOrders() {


    return this.state.ordered_foods.map((prop, key) => {
      return (
        <TouchableOpacity style={styles.order} onPress={() => this.viewOrderedItemDetails(prop)} key={key}>
          <View style={styles.order_text}>
            <Text style={styles.bold}>Order ID: </Text>
            <Text>{prop.id}</Text>
          </View>
          <View style={styles.order_text}>
            <Text style={styles.bold}>Total: </Text>
            <Text>{prop.total}</Text>
          </View>
          <View style={styles.order_text}>
            <Text style={styles.bold}>Status: </Text>
            <Text>{prop.status}</Text>
          </View>
          <View style={styles.order_text}>
            <Text style={styles.bold}>Time: </Text>
            <Text>{prop.time}</Text>
          </View>
        </TouchableOpacity>
      )
    })
  }

  _onRefresh = () => {
    this.setState({ refreshing: true });
    this.getOrders()
  }



  render() {
    return (


      <ScrollView

        style={{ backgroundColor: "#fff" }}
        refreshControl={
          <RefreshControl
            refreshing={this.state.refreshing}
            onRefresh={this._onRefresh}
          />
        }
      >
        {this.listOrders()}
      </ScrollView>


    );

  }
}

const styles = StyleSheet.create({
  bold: {
    fontWeight: 'bold'
  },
  order: {
    display: 'flex',
    backgroundColor: "#fff",
    padding: 20,
    margin: 5,
    borderRadius: 20,
    borderWidth: 2,
    borderColor: "#ffe680"
  },
  order_text: {
    display: 'flex',
    flexDirection: 'row'
  }
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

export default connect(mapStateToProps, mapDispatchToProps)(OrderedFoods)