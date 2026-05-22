(function () {
  'use strict';

  /* ── Geometría ─────────────────────────────────────────── */
  const CX = 200, CY = 200;
  const RD_IN = 130, RD_OUT = 178, RD_LBL = 117; // densidad
  const RF_IN = 88,  RF_OUT = 116, RF_LBL = 75;  // grasa

  const DENS_MIN = 1.020, DENS_MAX = 1.040;
  const FAT_MIN  = 0,     FAT_MAX  = 6.5;

  const NR = {
    est: { min: 11.5, max: 13.5 },
    esd: { min: 8.5,  max: 9.5  },
  };

  /* ── Fórmula de Ackermann ── */
  // EST = (d − 1) × 260 + 1.2 × G
  // ESD = EST − G
  function calcAckermann(d, g) {
    const EST = +((d - 1) * 260 + 1.2 * g).toFixed(2);
    const ESD = +(EST - g).toFixed(2);
    return { EST, ESD };
  }

  /* ── SVG helpers ───────────────────────────────────────── */
  const NS = 'http://www.w3.org/2000/svg';
  const r2d = d => d * Math.PI / 180;
  function el(tag, attrs) {
    const e = document.createElementNS(NS, tag);
    for (const [k, v] of Object.entries(attrs)) e.setAttribute(k, v);
    return e;
  }

  /* ── Dibujar escala ────────────────────────────────────── */
  function buildScale({ gId, min, max, step, major, fmt,
                         rIn, rOut, rLbl, color, lblColor, fs }) {
    const g = document.getElementById(gId);
    g.innerHTML = '';
    for (let v = min; v <= max + step * 0.01; v = +(v + step).toFixed(8)) {
      const pct = (v - min) / (max - min);
      const rad = r2d(pct * 360 - 90);
      const mod = +((v - min) % major).toFixed(6);
      const big = mod < step * 0.5 || (major - mod) < step * 0.5;
      const r1  = big ? rIn : rIn + (rOut - rIn) * 0.48;
      g.appendChild(el('line', {
        x1: CX + r1   * Math.cos(rad), y1: CY + r1   * Math.sin(rad),
        x2: CX + rOut * Math.cos(rad), y2: CY + rOut * Math.sin(rad),
        stroke: color, 'stroke-width': big ? 1.4 : 0.7, opacity: big ? 0.9 : 0.45,
      }));
      if (big && fmt) {
        const lx = CX + rLbl * Math.cos(rad);
        const ly = CY + rLbl * Math.sin(rad);
        const t  = el('text', {
          x: lx, y: ly, 'text-anchor': 'middle', 'dominant-baseline': 'central',
          'font-size': fs, fill: lblColor, 'font-family': "'Roboto Mono',monospace",
          transform: `rotate(${pct * 360 - 90 + 90},${lx},${ly})`,
        });
        t.textContent = fmt(v);
        g.appendChild(t);
      }
    }
    // etiqueta de escala en arco
    if (gId === 'g-density-scale') {
      const pid = 'arc-dens';
      g.appendChild(el('path', { id: pid,
        d: `M ${CX-106},${CY} A 106,106 0 0,1 ${CX+106},${CY}`, fill: 'none' }));
      const t = el('text', { 'font-size': '7.5', fill: color, opacity: '.65',
        'font-family': "'Inter',sans-serif", 'font-weight': '600', 'letter-spacing': '2' });
      t.innerHTML = `<textPath href="#${pid}" start-offset="20%">DENSIDAD (g/mL)</textPath>`;
      g.appendChild(t);
    } else {
      const pid = 'arc-fat';
      g.appendChild(el('path', { id: pid,
        d: `M ${CX-63},${CY} A 63,63 0 0,0 ${CX+63},${CY}`, fill: 'none' }));
      const t = el('text', { 'font-size': '7', fill: color, opacity: '.8',
        'font-family': "'Inter',sans-serif", 'font-weight': '600', 'letter-spacing': '2' });
      t.innerHTML = `<textPath href="#${pid}" start-offset="26%">GRASA (%)</textPath>`;
      g.appendChild(t);
    }
  }

  function drawScales() {
    buildScale({ gId: 'g-density-scale', min: DENS_MIN, max: DENS_MAX,
      step: 0.001, major: 0.005, fmt: v => v.toFixed(3),
      rIn: RD_IN, rOut: RD_OUT, rLbl: RD_LBL,
      color: '#1A396B', lblColor: '#1A396B', fs: '6.5' });
    buildScale({ gId: 'g-fat-scale', min: FAT_MIN, max: FAT_MAX,
      step: 0.5, major: 1, fmt: v => v.toFixed(0) + '%',
      rIn: RF_IN, rOut: RF_OUT, rLbl: RF_LBL,
      color: '#e05a10', lblColor: '#c04a08', fs: '7.5' });
  }

  /* ── Agujas ────────────────────────────────────────────── */
  function moveNeedle(id, pct) {
    document.getElementById(id).style.transform =
      `rotate(${pct * 360 - 90}deg)`;
  }
  function updateNeedles(d, g) {
    moveNeedle('needle-density',
      Math.min(Math.max((d - DENS_MIN) / (DENS_MAX - DENS_MIN), 0), 1));
    moveNeedle('needle-fat',
      Math.min(Math.max(g / FAT_MAX, 0), 1));
  }

  /* ── Barras del disco ──────────────────────────────────── */
  function updateDiscBars(est, esd) {
    const ep = Math.min(Math.max((est - 10) / 6, 0), 1);
    const sp = Math.min(Math.max((esd - 7)  / 5, 0), 1);
    const eOK = est >= NR.est.min && est <= NR.est.max;
    const sOK = esd >= NR.esd.min && esd <= NR.esd.max;
    document.getElementById('bar-est').setAttribute('width', (72 * ep).toFixed(1));
    document.getElementById('bar-esd').setAttribute('width', (72 * sp).toFixed(1));
    document.getElementById('bar-est').setAttribute('fill', eOK ? '#1A396B' : '#b82020');
    document.getElementById('bar-esd').setAttribute('fill', sOK ? '#2a5299' : '#b82020');
    document.getElementById('lbl-est').textContent = `EST: ${est}%`;
    document.getElementById('lbl-esd').textContent = `ESD: ${esd}%`;
  }

  /* ── Tarjetas de resultado ─────────────────────────────── */
  function setStatus(id, val, min, max) {
    const el = document.getElementById(id);
    if (val >= min && val <= max) {
      el.textContent = '✓ Dentro del rango normal';
      el.className   = 'range-status status-ok';
    } else if (val < min) {
      el.textContent = '▼ Por debajo del rango normal';
      el.className   = 'range-status status-low';
    } else {
      el.textContent = '▲ Por encima del rango normal';
      el.className   = 'range-status status-high';
    }
  }
  function updateCards(est, esd) {
    document.getElementById('results-grid').classList.add('visible');
    const eOK = est >= NR.est.min && est <= NR.est.max;
    const sOK = esd >= NR.esd.min && esd <= NR.esd.max;

    document.getElementById('val-est').innerHTML =
      `${est.toFixed(2)}<span class="res-unit">%</span>`;
    document.getElementById('val-esd').innerHTML =
      `${esd.toFixed(2)}<span class="res-unit">%</span>`;
    document.getElementById('val-est').style.color = eOK ? 'var(--blue)' : 'var(--red)';
    document.getElementById('val-esd').style.color = sOK ? 'var(--blue)' : 'var(--red)';

    const pE = Math.min(Math.max((est - 9.8)  / 4.4, 0), 1);
    const pS = Math.min(Math.max((esd - 7.6)  / 2.8, 0), 1);
    const bE = document.getElementById('bar-qr-est');
    const bS = document.getElementById('bar-qr-esd');
    bE.style.width      = (pE * 100) + '%';
    bE.style.background = eOK ? 'var(--blue)' : 'var(--red)';
    bS.style.width      = (pS * 100) + '%';
    bS.style.background = sOK ? 'var(--blue)' : 'var(--red)';

    setStatus('status-est', est, NR.est.min, NR.est.max);
    setStatus('status-esd', esd, NR.esd.min, NR.esd.max);
  }

  /* ── Interpretación ────────────────────────────────────── */
  function updateInterp(est, esd) {
    const box = document.getElementById('interp-box');
    const txt = document.getElementById('interp-text');
    const eOK = est >= NR.est.min && est <= NR.est.max;
    const sOK = esd >= NR.esd.min && esd <= NR.esd.max;
    let color, msg;
    if (eOK && sOK) {
      color = 'var(--green)';
      msg   = '✅ <strong>Muestra dentro de los parámetros normales.</strong> Ambos indicadores se encuentran en los rangos esperados para leche de vaca de buena calidad. No se detectan indicios de adulteración con agua ni anomalías composicionales.';
    } else if (!eOK && est < NR.est.min && !sOK && esd < NR.esd.min) {
      color = 'var(--red)';
      msg   = '🚨 <strong>Alta probabilidad de adulteración con agua.</strong> Tanto el EST como el ESD se encuentran por debajo del mínimo esperado. Este patrón es consistente con dilución de la muestra. Se recomienda repetir el análisis y verificar el origen de la muestra.';
    } else if (!sOK && esd < NR.esd.min) {
      color = 'var(--red)';
      msg   = '⚠️ <strong>ESD por debajo del rango normal.</strong> El ESD es el indicador más sensible para detectar agua agregada. El valor obtenido sugiere posible adulteración. Verifique la calibración del lactodensímetro y repita la determinación.';
    } else if (!eOK && est < NR.est.min) {
      color = 'var(--amber)';
      msg   = '⚠️ <strong>EST por debajo del rango normal.</strong> Podría deberse a una dilución leve, variaciones de raza o del ciclo de lactación. Compare con el ESD y realice análisis complementarios.';
    } else {
      color = 'var(--amber)';
      msg   = '🔎 <strong>Valor fuera del rango habitual.</strong> Revise los datos ingresados y confirme con métodos de referencia en laboratorio.';
    }
    box.style.borderLeftColor = color;
    txt.innerHTML = msg;
    box.classList.add('visible');
  }

  /* ── Validación ────────────────────────────────────────── */
  function validate(d, g) {
    const e = {};
    if (isNaN(d) || d < 1.015 || d > 1.050) e.density = 'Ingresa un valor entre 1.015 y 1.050 g/mL';
    if (isNaN(g) || g < 0.1   || g > 10.0)  e.fat     = 'Ingresa un valor entre 0.1 y 10.0 %';
    return e;
  }
  function showErrors(e) {
    document.getElementById('err-density').textContent = e.density || '';
    document.getElementById('err-fat').textContent     = e.fat     || '';
    document.getElementById('inp-density').classList.toggle('err', !!e.density);
    document.getElementById('inp-fat').classList.toggle('err',     !!e.fat);
  }

  /* ── Calcular ──────────────────────────────────────────── */
  function calculate() {
    const d = parseFloat(document.getElementById('inp-density').value);
    const g = parseFloat(document.getElementById('inp-fat').value);
    const e = validate(d, g);
    showErrors(e);
    if (Object.keys(e).length) return;
    const { EST, ESD } = calcAckermann(d, g);
    updateNeedles(d, g);
    updateDiscBars(EST, ESD);
    updateCards(EST, ESD);
    updateInterp(EST, ESD);
  }

  /* ── Sliders ↔ Inputs ──────────────────────────────────── */
  function syncPair(inpId, slId, dec) {
    const inp = document.getElementById(inpId);
    const sl  = document.getElementById(slId);
    inp.addEventListener('input', () => {
      sl.value = inp.value;
      if (document.getElementById('results-grid').classList.contains('visible')) calculate();
    });
    sl.addEventListener('input', () => {
      inp.value = (+sl.value).toFixed(dec);
      if (document.getElementById('results-grid').classList.contains('visible')) calculate();
    });
  }

  /* ── Limpiar ───────────────────────────────────────────── */
  function clearAll() {
    document.getElementById('inp-density').value = '1.030';
    document.getElementById('inp-fat').value     = '3.5';
    document.getElementById('sl-density').value  = '1.030';
    document.getElementById('sl-fat').value      = '3.5';
    showErrors({});
    updateNeedles(1.030, 3.5);
    ['bar-est','bar-esd'].forEach(id => {
      document.getElementById(id).setAttribute('width', '0');
    });
    document.getElementById('bar-est').setAttribute('fill', '#1A396B');
    document.getElementById('bar-esd').setAttribute('fill', '#2a5299');
    document.getElementById('lbl-est').textContent = 'EST: —';
    document.getElementById('lbl-esd').textContent = 'ESD: —';
    document.getElementById('results-grid').classList.remove('visible');
    document.getElementById('interp-box').classList.remove('visible');
  }

  /* ── Init ──────────────────────────────────────────────── */
  drawScales();
  updateNeedles(1.030, 3.5);
  syncPair('inp-density', 'sl-density', 3);
  syncPair('inp-fat',     'sl-fat',     1);
  document.getElementById('btn-calc').addEventListener('click',  calculate);
  document.getElementById('btn-clear').addEventListener('click', clearAll);
  document.addEventListener('keydown', e => { if (e.key === 'Enter') calculate(); });

})();