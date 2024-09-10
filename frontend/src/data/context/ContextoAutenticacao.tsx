"use client"
import { createContext, useCallback, useEffect, useState } from "react"
import { UsuarioDTO } from "../model/Usuario"
import useSessao from "../hooks/useSessao"
import useApi from "../hooks/useApi"

interface ContextoAutenticacaoProps {
    carregando: boolean
    usuarioAutenticado: UsuarioDTO | null
    registrar: (usuario: UsuarioDTO) => Promise<void>
    login: (usuario: UsuarioDTO) => Promise<void>
    logout: () => void
}

const ContextoAutenticacao = createContext<ContextoAutenticacaoProps>({} as any)

export function ProvedorAutenticacao(props: any) {
    const { httpPost } = useApi()
    const {
        token,
        usuarioAutenticado,
        criar: criarSessao,
        limpar: limparSessao,
    } = useSessao()

    const [carregando, setCarregando] = useState<boolean>(true)

    const iniciarSessao = useCallback(async () => {
        if (!token || !usuarioAutenticado) return setCarregando(false)
        setCarregando(false)
    }, [token, usuarioAutenticado])

    useEffect(() => {
        iniciarSessao()
    }, [iniciarSessao])

    async function registrar(usuario: UsuarioDTO) {
        const resp = await httpPost("/cadastrar", usuario)
        console.log('REGISTRO RESPOSTAS DO BACKEND', resp)
        if (resp.sucesso) await login(usuario)
    }

    async function login(usuario: UsuarioDTO) {
        const resp = await httpPost("/login", usuario)
        console.log('LOGIN RESPOSTAS DO BACKEND', resp)
        criarSessao(resp.json)
    }

    function logout() {
        limparSessao()
    }

    return (
        <ContextoAutenticacao.Provider
            value={{
                carregando,
                usuarioAutenticado,
                login,
                logout,
                registrar,
            }}
        >
            {props.children}
        </ContextoAutenticacao.Provider>
    )
}

export default ContextoAutenticacao