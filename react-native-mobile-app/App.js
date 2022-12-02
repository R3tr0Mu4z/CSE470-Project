import 'react-native-gesture-handler';
import * as React from 'react';
import { StyleSheet, Text, View } from 'react-native';
import Cart from './classes/Cart.js'
import Navigator from './classes/Navigator.js'
import { createStore } from 'redux';
import { persistStore, persistReducer } from 'redux-persist'
import { Provider } from 'react-redux';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { CartProvider } from './context/CartContext.js'
import FlashMessage from "react-native-flash-message";

const initialState = {
  token: null
}

const reducer = (state = initialState, action) => {
  switch (action.type) {
    case 'SETTOKEN':
      return { token: action.token }
  }
  return state
}
const persistConfig = {
  key: 'root',
  blacklist: 'socket',
  storage: AsyncStorage,
}

const persistedReducer = persistReducer(persistConfig, reducer)

let store = createStore(persistedReducer);
let persistor = persistStore(store)

class App extends React.Component  {


  constructor() {
    super();
    this.state = {
      cart_args: {},
      cart_ref: null
    }
  }
  
  handleRef = (r) => {
    console.log(r, 'CART REFFFFF')
    if (this.state.cart_ref == null) {
      this.setState({cart_ref: r})
      // console.log('cart ref updated', 'APP SCREEN')
    }
  }


  render() {

    // console.log(initialState, 'this props app')
    // console.log(this.state.cart_ref, 'cart ref')
    return (

      <CartProvider value={this.state.cart_ref}>
          <Provider store={store}>

              <Navigator cart_ref={this.state.cart_ref} />
              <Cart ref={r => this.handleRef(r)} />
              <FlashMessage position="bottom" />
          </Provider>

      </CartProvider>
    );
  }





}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
    alignItems: 'center',
    justifyContent: 'center',
  },
});

export default App