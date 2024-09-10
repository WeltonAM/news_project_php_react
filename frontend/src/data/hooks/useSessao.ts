import cookie from "js-cookie";
import jwtDecode from "jwt-decode";
import { useCallback, useState } from "react";
import { UsuarioDTO } from "../model/Usuario";

export default function useSessao() {
  const nomeCookie = "authorization";

  const inicializarEstado = () => {
    const estado = obterEstado();
    return {
      token: estado?.token ?? null,
      usuarioAutenticado: estado?.usuario ?? null,
    };
  };

  const [estado, setEstado] = useState(inicializarEstado);
  const { token, usuarioAutenticado } = estado;

  const carregarSessao = useCallback(() => {
    const estadoAtualizado = obterEstado();
    setEstado({
      token: estadoAtualizado?.token ?? null,
      usuarioAutenticado: estadoAtualizado?.usuario ?? null,
    });
  }, []);

  function criar(jwt: string) {
    cookie.set(nomeCookie, jwt, {
      expires: 1,
      sameSite: "None",
      secure: true,
    });
    carregarSessao();
  }

  function limpar() {
    setEstado({ token: null, usuarioAutenticado: null });
    cookie.remove(nomeCookie);
  }

  function obterEstado(): { token: string; usuario: UsuarioDTO } | null {
    const jwt = cookie.get(nomeCookie);
    if (!jwt) return null;

    try {
      const decoded: any = jwtDecode(jwt);
      const expired = decoded.exp < Date.now() / 1000;

      if (expired) {
        cookie.remove(nomeCookie);
        return null;
      }

      return {
        token: jwt,
        usuario: {
          id: decoded.id,
          nome: decoded.nome,
          email: decoded.email,
        },
      };
    } catch (error) {
      cookie.remove(nomeCookie);
      return null;
    }
  }

  return { criar, limpar, token, usuarioAutenticado };
}
