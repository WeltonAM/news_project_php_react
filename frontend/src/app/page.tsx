"use client";
import useAutenticacao from "@/data/hooks/useAutenticacao";
import useFormAutenticacao from "@/data/hooks/useFormAutenticacao";
import { useRouter } from "next/navigation";
import { useEffect } from "react";
import Mensagens from "./components/shared/Mensagem";
import useMensagens from "@/data/hooks/useMessagem";

interface TextInputProps {
  label: string;
  type?: string;
  value: string;
  onChange: (e: React.ChangeEvent<HTMLInputElement>) => void;
  id: string;
  name: string;
  autocomplete?: string;
}

interface ButtonProps {
  onClick: () => void;
  children: React.ReactNode;
  variant?: "default" | "subtle";
  className?: string;
}

export default function Autenticacao() {
  const router = useRouter();
  const { usuario, modo, alterarUsuario, alternarModo } = useFormAutenticacao();
  const { usuarioAutenticado, registrar, login } = useAutenticacao();
  const { adicionarErro } = useMensagens();

  function alterarAtributo(atributo: string) {
    return (e: any) => {
      alterarUsuario({
        ...usuario,
        [atributo]: e?.target?.value ?? e,
      });
    };
  }

  function validarCamposObrigatorios() {
    if (modo === "registro" && !usuario.nome) {
      adicionarErro("O campo de nome é obrigatório.");
      return false;
    }

    if (!usuario.email) {
      adicionarErro("O campo de email é obrigatório.");
      return false;
    }
    if (!usuario.senha) {
      adicionarErro("O campo de senha é obrigatório.");
      return false;
    }
    return true;
  }

  function handleSubmit() {
    if (validarCamposObrigatorios()) {
      modo === "registro" ? registrar(usuario) : login(usuario);
    }
  }

  useEffect(() => {
    if (usuarioAutenticado) {
      router.push("/inicio");
    }
  }, [usuarioAutenticado, router]);

  return (
    <div
      className="min-h-screen bg-cover bg-center"
    >
      <div className="flex flex-col justify-center items-center gap-5 h-screen">
        <span className="text-3xl font-black self-center text-white">
          {modo === "login" ? "Entre com a sua conta" : "Cadastre-se na plataforma"}
        </span>

        <div className="flex flex-col gap-1 w-96 bg-neutral-900 p-9 rounded-md border border-zinc-700">
          {modo === "registro" && (
            <TextInput
              label="Nome"
              value={usuario.nome ?? ""}
              onChange={alterarAtributo("nome")}
              id="nome"
              name="nome"
              autocomplete="name"
            />
          )}
          <TextInput
            label="Email"
            value={usuario.email ?? ""}
            onChange={alterarAtributo("email")}
            id="email"
            name="email"
            autocomplete="email"
          />
          <TextInput
            label="Senha"
            type="password"
            value={usuario.senha ?? ""}
            onChange={alterarAtributo("senha")}
            id="senha"
            name="senha"
            autocomplete="current-password"
          />
          <div className="flex-1 flex flex-col gap-3 mt-5">
            <Button
              onClick={handleSubmit}
            >
              {modo === "registro" ? "Registrar" : "Login"}
            </Button>
            <Button onClick={alternarModo} variant="subtle" className="text-white">
              {modo === "registro" ? "Já possui conta?" : "Deseja se registrar?"}
            </Button>
          </div>
        </div>
        <div className="absolute top-4 right-4">
          <Mensagens />
        </div>
      </div>
    </div>
  );
}

function TextInput({ label, type = "text", value, onChange, id, name, autocomplete }: TextInputProps) {
  return (
    <div className="flex flex-col gap-1">
      <label htmlFor={id} className="text-white">{label}</label>
      <input
        type={type}
        value={value}
        onChange={onChange}
        id={id}
        name={name}
        autoComplete={autocomplete}
        className="px-4 py-2 rounded-md bg-black text-white border border-stone-800"
      />
    </div>
  );
}

function Button({ onClick, children, variant = "default", className = "" }: ButtonProps) {
  return (
    <button
      onClick={onClick}
      className={`px-4 py-2 rounded-md ${variant === "default"
        ? "bg-violet-900 border border-gray-400"
        : "bg-transparent border border-stone-800"
        } text-white ${className}`}
    >
      {children}
    </button>
  );
}