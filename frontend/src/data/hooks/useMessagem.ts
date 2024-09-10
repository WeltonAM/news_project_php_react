import { useContext } from "react";
import MensagemContexto from "../context/MensagemContexto";

const useMensagens = () => useContext(MensagemContexto);
export default useMensagens;
