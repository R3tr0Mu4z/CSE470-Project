import React from 'react'

const CustomerContext = React.createContext()

export const CustomerProvider = CustomerContext.Provider
export const CustomerConsumer = CustomerContext.Consumer

export default CustomerContext