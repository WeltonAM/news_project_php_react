import { useCallback } from "react";
import useSessao from "./useSessao";
import RespostaApi from "../model/RespostaApi";
import useMensagens from "./useMessagem";

export default function useApi() {
  const { token } = useSessao();
  const { adicionarErro } = useMensagens();
  const baseUrl = process.env.NEXT_PUBLIC_API_URL!;

  const renderizarErrosSeExistir = useCallback(
    function (err: any) {
      if (!err) return;

      console.log(err);

      if (Array.isArray(err)) {
        return err.map(adicionarErro);
      } else if (typeof err === "string") {
        adicionarErro(err);
      } else {
        adicionarErro("Erro desconhecido");
      }
    },
    [adicionarErro]
  );

  const httpGet = useCallback(
    async function (path: string): Promise<RespostaApi> {
      const url = `${baseUrl}${path}`;

      const res = await fetch(url, {
        method: "GET",
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });

      const json = await res.json();

      renderizarErrosSeExistir(json.erros);

      return {
        json,
        status: res.status,
        sucesso: sucesso(res.status),
        erros: json.erros,
      };
    },
    [baseUrl, token, renderizarErrosSeExistir]
  );

  const httpPost = useCallback(
    async function (path: string, body: any): Promise<RespostaApi> {
      const url = `${baseUrl}${path}`;

      const res = await fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify(body),
      });

      const json = await res.json();
      console.log(json);

      renderizarErrosSeExistir(json.erros);

      return {
        json,
        status: res.status,
        sucesso: sucesso(res.status),
        erros: json.erros,
      };
    },
    [baseUrl, token, renderizarErrosSeExistir]
  );

  const httpDelete = useCallback(
    async function (path: string): Promise<RespostaApi> {
      const url = `${baseUrl}${path}`;

      const resp = await fetch(url, {
        method: "DELETE",
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });

      const json = await resp.json();

      renderizarErrosSeExistir(json.erros);

      return {
        json,
        status: resp.status,
        sucesso: sucesso(resp.status),
        erros: json.erros,
      };
    },
    [baseUrl, token, renderizarErrosSeExistir]
  );

  function sucesso(status: number): boolean {
    return status >= 200 && status < 300;
  }

  return { httpGet, httpPost, httpDelete };
}
