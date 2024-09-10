"use client"
import { useRouter } from "next/navigation"
import { useEffect } from "react"
import useAutenticacao from "@/data/hooks/useAutenticacao"

interface ForcarUsuarioAutenticadoProps {
    children: any
}

export default function ForcarUsuarioAutenticado(props: ForcarUsuarioAutenticadoProps) {
    const router = useRouter()
    const { usuarioAutenticado, carregando } = useAutenticacao()

    useEffect(() => {
        if (!carregando && !usuarioAutenticado) {
            router.push("/")
        }
    }, [carregando, usuarioAutenticado, router])

    if (carregando || !usuarioAutenticado) {
        return null
    }

    return props.children
}