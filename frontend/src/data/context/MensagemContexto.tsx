"use client"
import { createContext, useCallback, useState } from "react"

export type Mensagem = {
    tipo: "erro" | "sucesso"
    texto: string
    tempo?: number
}

interface MensagemContextoProps {
    mensagens: Mensagem[]
    adicionarSucesso: (texto: string, tempo?: number) => void
    adicionarErro: (texto: string, tempo?: number) => void
    excluir: (msg: Mensagem) => void
}

const MensagemContexto = createContext<MensagemContextoProps>({} as any)

export function MensagemProvider(props: any) {
    const [mensagens, setMensagens] = useState<Mensagem[]>([])

    function jaExiste(mensagens: Mensagem[], msg: Mensagem) {
        return mensagens.some((m) => {
            return (
                JSON.stringify(m.texto) === JSON.stringify(msg.texto) &&
                m.tipo === msg.tipo
            )
        })
    }

    function adicionar(mensagens: Mensagem[], msg: Mensagem) {
        if (jaExiste(mensagens, msg)) return
        setMensagens((mensagens) => [...mensagens, msg])
        if (msg.tempo) {
            setTimeout(() => excluir(msg), msg.tempo)
        }
    }

    function adicionarSucesso(texto: string) {
        adicionar(mensagens, { tipo: "sucesso", texto, tempo: 5000 })
    }

    function adicionarErro(texto: string) {
        adicionar(mensagens, { tipo: "erro", texto, tempo: 7000 })
    }

    function excluir(msg: Mensagem) {
        setMensagens((mensagens) => mensagens.filter((m) => m !== msg))
    }

    return (
        <MensagemContexto.Provider
            value={{
                mensagens,
                adicionarSucesso,
                adicionarErro,
                excluir,
            }}
        >
            {props.children}
        </MensagemContexto.Provider>
    )
}

export default MensagemContexto