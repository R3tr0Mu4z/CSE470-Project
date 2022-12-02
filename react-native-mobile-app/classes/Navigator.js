import React, { Component } from 'react';
import {
  StyleSheet
} from 'react-native';
import { connect } from 'react-redux';
import Customer from './Customer.js'
import RestaurantSearcher from './RestaurantSearcher.js'
import Restaurant from './Restaurant'
import OrderedFoods from './OrderedFoods'
import OrderedFood from './OrderedFood'
import CartContext from '../context/CartContext'
import { CustomerProvider } from '../context/CustomerContext.js'
import Icon from 'react-native-vector-icons/FontAwesome';
import { NavigationContainer } from '@react-navigation/native';
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';
import { createStackNavigator } from '@react-navigation/stack';
const Tab = createBottomTabNavigator();

const Stack = createStackNavigator();

const Main = () => {
  return (
    <Stack.Navigator>
      <Stack.Screen name="Search Restaurant" component={RestaurantSearcher} />
      <Stack.Screen name="Restaurant" component={Restaurant} />
    </Stack.Navigator>
  );
}


const Orders = () => {
  return (
    <Stack.Navigator>
      <Stack.Screen name="Orders" component={OrderedFoods} />
      <Stack.Screen name="Order" component={OrderedFood} />
    </Stack.Navigator>
  );
}


const Tabs = () => {
  return (
    <Tab.Navigator

      screenOptions={{
        headerShown: false, activeTintColor: '#edbe00',
        inactiveTintColor: 'gray',
      }}
    >
      <Tab.Screen name="Search" component={Main}
        options={{
          tabBarLabel: 'Search',
          tabBarIcon: ({ color, size }) => (
            <Icon name="search" size={22} color="#edbe00" />
          ),
          screenOptions: {
            activeTintColor: '#000',
          },
        }}
      />

      <Tab.Screen name="OrdersTab" component={Orders}
        options={{
          tabBarLabel: 'Orders',
          tabBarIcon: ({ color, size }) => (
            <Icon name="list" size={22} color="#edbe00" />
          ),
          screenOptions: {
            activeTintColor: '#000',

          },
        }}
      />

      <Tab.Screen name="Profile" component={Customer}
        options={{
          tabBarLabel: 'Profile',
          tabBarIcon: ({ color, size }) => (
            <Icon name="user" size={22} color="#edbe00" />
          ),
          screenOptions: {
            activeTintColor: '#000',
          },
        }}
      />


    </Tab.Navigator>
  );
}

class Navigator extends Component {
  static contextType = CartContext
  constructor(props) {
    super(props);
    this.state = {
      cart_ref: null
    };

    this.forceUpdateParent = this.forceUpdateParent.bind(this);

  }

  forceUpdateParent() {

    console.log("FORCE UPDATE PARENT")
    this.forceUpdate();
  }

  componentDidUpdate(prevProps) {
    // console.log("HERE")
    if (prevProps.cart_ref !== this.props.cart_ref) {
      // console.log("CART REF RES")
      this.setState({ cart_ref: this.props.cart_ref });
    }
  }




  render() {



    if (this.props?.token) {
      return (
        <NavigationContainer>
          <CustomerProvider value={this.forceUpdateParent}>
            <Tabs screenProps={this.state.cart_ref} />
          </CustomerProvider>
        </NavigationContainer>

      );
    } else {



      return (
        <Customer forceUpdateParent={this.forceUpdateParent} />
      )
    }


  }
}

const styles = StyleSheet.create({
  input: {
    height: 40,
    margin: 12,
    borderWidth: 1,
    width: 250,
    borderRadius: 10,
    borderColor: "#888",
    padding: 10,
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
  food_img: {
    height: 100,
    width: 100,
    borderRadius: 100,
    paddingRight: 40
  },
  restaurant: {
    display: 'flex',
    flexDirection: 'row',
    width: 400,
    padding: 5
  },
  food_text: {
    paddingLeft: 20,
    display: 'flex',
    flexDirection: 'column',
    justifyContent: 'center',
  },
  food_text_sub_heading: {
    fontSize: 30,
    fontWeight: 'bold',
  },
  food_text_sub_heading: {
    fontWeight: 'bold'
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


export default connect(mapStateToProps, mapDispatchToProps)(Navigator)