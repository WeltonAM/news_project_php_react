import { Mensagem } from "@/data/context/MensagemContexto";
import useMensagens from "@/data/hooks/useMessagem";
import { IconX } from "@tabler/icons-react"

interface CodigoParaMensagem {
    [key: string]: string;
}

const codigoParaMensagem: CodigoParaMensagem = {
    VAZIO: "Os campos não podem ficar vazios",
    SOBRENOME_INVALIDO: "Adicione um sobrenome válido",
    SENHA_FRACA: "Senha inválida",
    DESCRICAO_VAZIA: "Descrição não pode ser vazia",
    EMAIL_INVALIDO: "Email inválido",
    ERRO_DESCONHECIDO: "Atualize os dados e tente novamente",
    STATUS_INVALIDO: "Status inválido",
};

export default function Mensagens() {
    const { mensagens, excluir } = useMensagens()

    function renderizarMensagem(msg: Mensagem) {
        let texto = '';

        if (codigoParaMensagem[msg.texto.codigo]) {
            texto = codigoParaMensagem[msg.texto.codigo];
        }

        return (
            <div key={msg.texto} className={`flex items-center gap-2 p-4 rounded-md shadow-md ${msg.tipo === "sucesso" ? "bg-green-400" : "bg-red-400"}`}>
                <div className="mr-3">
                    <h1 className="text-lg font-semibold">{msg.tipo === "sucesso" ? "Efetuado com sucesso" : "Ocorreu um erro"}</h1>
                    <p>{texto}</p>
                </div>

                <button onClick={() => excluir(msg)} className="ml-auto">
                    <div className={`${msg.tipo === "sucesso" ? "bg-green-500" : "bg-red-500"} rounded-full p-2 flex items-center justify-center`}>
                        <IconX size={20} />
                    </div>
                </button>
            </div>
        )
    }

    return (
        <div className="flex flex-col gap-2">
            {mensagens && mensagens.map(renderizarMensagem)}
        </div>
    )
}