#!/usr/bin/env bash
set -euo pipefail

# PILAR 1: simular carga (aunque sea simple)
BASE_URL="${BASE_URL:-http://localhost/vozelia_site/index.php}"
N="${N:-200}"
CONC="${CONCURRENCY:-20}"

echo "Hitting $BASE_URL ($N req, conc=$CONC)"...

# cola simple
pids=()
for ((i=1; i<=N; i++)); do
  curl -sS "$BASE_URL?controller=pages&action=home" >/dev/null &
  pids+=("$!")

  # salud cada 10
  if (( i % 10 == 0 )); then
    curl -sS "$BASE_URL?controller=ops&action=health" >/dev/null &
    pids+=("$!")
  fi

  # limita concurrencia
  if ((${#pids[@]} >= CONC)); then
    wait "${pids[0]}" || true
    pids=("${pids[@]:1}")
  fi
done

# espera todos
for p in "${pids[@]}"; do
  wait "$p" || true
done

echo "Done. Mira: index.php?controller=ops&action=status" 
