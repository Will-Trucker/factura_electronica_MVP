
import Web3 from 'web3';

let isConnected = false;
let ethBalance = "";

document.getElementById('web3boton').addEventListener('click', onConnect);

export function sesionweb3(){
    // Función para detectar el proveedor actual
    let provider = detectCurrentProvider();
  console.log(provider)
    // Función para conectarse
}

function detectCurrentProvider() {
    let provider;
    if (window.ethereum) {
      provider = window.ethereum;
    } else if (window.web3) {
      provider = window.web3.currentProvider;
    } else {
      console.log("Non-ethereum browser detected. You should install Metamask");
    }
    return provider;
  }

async function onConnect() {
  try {
    const currentProvider = detectCurrentProvider();
    if (currentProvider) {
      await currentProvider.request({method: 'eth_requestAccounts'});
      const web3 = new Web3(currentProvider);
      const userAccount = await web3.eth.getAccounts();
      const account = userAccount[0];
      ethBalance = await web3.eth.getBalance(account);
      isConnected = true;
      var cuenta = document.getElementById("cuentaEth");
      cuenta.value = account;
      console.log(ethBalance)
      console.log(account)
      console.log(userAccount)
      
    }
  } catch (err) {
    console.log(err);
  }
}

