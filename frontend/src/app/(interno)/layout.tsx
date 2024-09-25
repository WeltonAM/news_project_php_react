import ForcarUsuarioAutenticado from "@/components/auth/ForcarUsuarioAutenticacao"

export interface PaginaProps {
    children: any
}

export default function Pagina(props: PaginaProps) {
    return (
        <ForcarUsuarioAutenticado>
            <div className="flex flex-col md:flex-row">
                <div className="flex flex-1">
                    {props.children}
                </div>
            </div>
        </ForcarUsuarioAutenticado>
    )
}