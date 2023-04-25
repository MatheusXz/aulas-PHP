import { StatusBar } from 'expo-status-bar';
import { StyleSheet, Text, View } from 'react-native';
import Exemplo from '../src/Components/Exemplo';


export default function App() {
  return (
    <View style={styles.container}>
      <Text style={styles.texto}>Open up App.js to start working on your app!</Text>
      <StatusBar style="auto" />
      <Exemplo /><Exemplo />
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    
    flex: 1,
    paddingTop: 8,
    backgroundColor: '#fff',
    alignItems: 'center',
    justifyContent: 'center',
  },

  texto: {
    width: 120,
    borderWidth: 1,
    borderColor: '#ff0'
  }
});
